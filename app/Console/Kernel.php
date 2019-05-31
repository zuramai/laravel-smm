<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Deposit;
use App\Deposit_method;
use App\User;
use App\Order;
use App\Provider;
use App\Orders_pulsa;
use App\Balance_history;
use DB;
use Carbon\Carbon;
use App\Helpers\Oper\Bulkfollows as Bulkfollows;
use App\Helpers\Oper\PerfectSMM as PerfectSMM;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        
        // REFUND ORDER SOSMED
        $schedule->call(function() {
            echo "CHECKING REFUND";
            $orders = Order::whereIn('status',['Error','Partial'])->where('refund',0)->get();

            foreach($orders as $order) {
                $id = $order->id;
                $start = $order->start_count;
                $remains = $order->remains;
                $price = $order->price;
                $quantity = $order->quantity;

                if($order->status == 'Error') {
                    $find = Order::find($id);
                    $find->refund = 1;
                    $find->save();

                    $user = User::find($order->user_id);
                    $user->balance += $price;
                    $user->save();

                    $balance_history = new Balance_history;
                    $balance_history->user_id = $user->id;
                    $balance_history->quantity = $price;
                    $balance_history->action = "Refund";
                    $balance_history->desc = "Saldo dikembalikan sebesar Rp $price pembelian sosmed #$id";
                    $balance_history->save();
                    echo "Refunded Rp $price for order id => $id";
                }else if($order->status == 'Partial'){
                    $find = Order::find($id);
                    $find->refund = 1;
                    $find->save();

                    $user = User::find($order->user_id);
                    $bagi = $remains / $quantity;
                    $newprice = $price / $bagi;
                    $user->balance += $newprice;
                    $user->save();

                    $balance_history = new Balance_history;
                    $balance_history->user_id = $user->id;
                    $balance_history->quantity = $newprice;
                    $balance_history->action = "Refund";
                    $balance_history->desc = "Saldo dikembalikan sebesar Rp $newprice untuk pembelian sosmed #$id";
                    $balance_history->save();
                    echo "Refunded Rp $newprice for order id => $id";
                }
            }
        });
        // REFUND ORDER PULSA
        $schedule->call(function() {
            echo "CHECKING REFUND PULSA";
            $orders = Orders_pulsa::whereIn('status',['Error'])->where('refund',0)->get();

            foreach($orders as $order) {
                $id = $order->id;
                $start = $order->start_count;
                $remains = $order->remains;
                $price = $order->price;
                $quantity = $order->quantity;

                if($order->status == 'Error') {
                    $find = Orders_pulsa::find($order->id);
                    $find->refund = 1;
                    $find->save();

                    $user = User::find($order->user_id);
                    $user->balance += $price;
                    $user->save();

                    $balance_history = new Balance_history;
                    $balance_history->user_id = $user->id;
                    $balance_history->quantity = $price;
                    $balance_history->action = "Refund";
                    $balance_history->desc = "Saldo dikembalikan sebesar Rp $price untuk pembelian pulsa #$id";
                    $balance_history->save();
                    echo "Refunded Rp $price for order id => $id";
                }
            }
        });
        // STATUS PORTALPULSA
        $schedule->call(function() {
            echo "CHECKING PORTALPULSA";
            $orders = DB::table('orders_pulsas')->select('*')
                        ->where('orders_pulsas.status','Pending')
                        ->join('services_pulsas','orders_pulsas.service_id', 'services_pulsas.id')
                        ->join('providers','services_pulsas.provider_id','providers.id')
                        ->get();
            if(!$orders){
                return "Order pending not found";
            }

            foreach($orders as $order) {
                echo "CHECKING";
                $oid = $order->oid;
            
                $api_postdata = "inquiry=STATUS&trxid_api=$oid";
                $url = 'https://portalpulsa.com/api/connect/';

                $user_id = env('PORTALPULSA_USER_ID');
                $key = env('PORTALPULSA_KEY');
                $secret = env('PORTALPULSA_SECRET');

                $header = array(
                            'portal-userid: '.$user_id,
                            'portal-key: '.$key, // lihat hasil autogenerate di member area
                            'portal-secret: '.$secret, // lihat hasil autogenerate di member area
                            );
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                $chresult = curl_exec($ch);
                curl_close($ch);

                $json_result = json_decode($chresult,true);
                // echo $chresult;  
                if(isset($json_result['message'][0]['sn']))
                {
                    echo "SUCCESS";
                    $sn = $json_result['message'][0]['sn'];    
                    $u_status = $json_result['message'][0]['status'];
                }else if($json_result['result'] == 'failed'){
                    $sn = $json_result['message'];    
                    $u_status = 2;
                }else{
                    $u_status = $json_result['message'][0]['status'];
                    $sn = $json_result['message'][0]['note'];   
                }
                // echo $chresult;
                 if ($u_status == "1") {
                    $un_status = "Pending";
                 } else if ($u_status == "2") {
                    $un_status = "Error";
                 } else if ($u_status == "3") {
                    $un_status = "Partial";
                 } else if ($u_status == "4") {
                    $un_status = "Success";
                 } else {
                     $un_status = "Pending";
                 }

                 $update = Orders_pulsa::find($order->id);
                 $update->status = $un_status;
                 $update->sn = $sn;
                 $update->save(); 

                 echo "ORDER ID => $oid, Status => $un_status -";

            }
        });     
        // STATUS IRVANKEDE
        $schedule->call(function() {
            echo "CHECKING IRV";
            $api_id = env('API_ID_IRV');
            $provider = Provider::where('name','IRV')->first();
            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();

                foreach($order as $data_order) {
                    $poid = $data_order->poid;
                    $api_postdata = "api_id=$api_id&api_key=$api_key&id=$poid";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.irvankede-smm.co.id/status');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $chresult = curl_exec($ch);
                    curl_close($ch);
                    $json_result = json_decode($chresult);

                    if($json_result->status == true) {
                        $update = Order::find($data_order->id);
                        $update->status = $json_result->data->status;
                        $update->start_count = $json_result->data->start_count;
                        $update->remains = $json_result->data->remains;
                        $update->save();
                        echo "SUKSES UPDATE IRV ID ".$update->id;
                    }
                }
            }
        });
        // STATUS SMMINDO
        $schedule->call(function() {
            echo "SMMINDO";
            $provider = Provider::where('name','SMMINDO')->first();

            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();

                foreach($order as $data_order) {
                    $poid = $data_order->poid;
                    $api_postdata = "api_key=$api_key&action=status&id=$poid";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $provider->api_link);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $chresult = curl_exec($ch);
                    curl_close($ch);
                    $json_result = json_decode($chresult);

                    if($json_result->status == true) {
                        $update = Order::find($data_order->id);
                        $update->status = $json_result->data->status;
                        $update->start_count = $json_result->data->start_count;
                        $update->remains = $json_result->data->remains;
                        $update->save();
                        echo "SUKSES UPDATE SMMINDO ID ".$update->id;
                    }
                }
            }
        });
        // STATUS VIPMEMBER
        $schedule->call(function() {
            echo "VIPMEMBER";
            $provider = Provider::where('name','VIPMEMBER')->first();
            
            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();

                foreach($order as $data_order) {
                    $poid = $data_order->poid;
                    $api_postdata = "api_key=$api_key&action=status&order_id=$poid";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $provider->api_link);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $chresult = curl_exec($ch);
                    curl_close($ch);
                    $json_result = json_decode($chresult);

                    if($json_result->status == true) {
                        $update = Order::find($data_order->id);
                        $update->status = $json_result->data->status;
                        $update->start_count = $json_result->data->start_count;
                        $update->remains = $json_result->data->remains;
                        $update->save();
                        echo "SUKSES UPDATE VIPMEMBER ID ".$update->id;
                    }
                }
            }
        });
        // STATUS GATENZ
        $schedule->call(function() {
            echo "CHECKING GATENZ";
            $provider = Provider::where('name','GATENZ')->first();
            $api_key = $provider->api_key;

            $order = Order::select('orders.id','poid')
                ->join('services','orders.service_id','services.id')
                ->where('services.provider_id',$provider->id)
                ->whereIn('orders.status', ['Pending','Processing'])->get();

            foreach($order as $data_order) {
                $poid = $data_order->poid;
                $api_postdata = "action=status&api_key=$api_key&id=$poid";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.gatenz-panel.com/api/');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $chresult = curl_exec($ch);
                curl_close($ch);
                $json_result = json_decode($chresult);

                if($json_result->status == true) {
                    $update = Order::find($data_order->id);
                    $update->status = $json_result->data->status_order;
                    $update->start_count = $json_result->data->start_count;
                    $update->remains = $json_result->data->remains;
                    $update->save();
                    echo "SUKSES UPDATE GATENZ ID ".$update->id;
                }
            }
        });
        //STATUS JAP
        $schedule->call(function() {
            echo "CHECKING JAP";
            $provider = Provider::where('name','JAP')->first();
            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();


                $api_key = $provider->api_key;
                foreach($order as $data) {
                    $poid = $data->poid;
                    $api_postdata = "key=$api_key&action=status&order=$poid";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://justanotherpanel.com/api/v2");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $chresult = curl_exec($ch);
                    curl_close($ch);
                    $json_result = json_decode($chresult);
                    // dd($json_result);

                    if(isset($json_result->error)) {
                        echo $json_result->error;
                    }else{

                    $u_status = $json_result->status;
                      $u_start = $json_result->start_count;
                      $u_remains = $json_result->remains;
                     if ($u_status == "Pending") {
                        $un_status = "Pending";
                     } else if ($u_status == "Processing") {
                        $un_status = "Processing";
                     }  else if ($u_status == "In progress") {
                        $un_status = "Processing";
                     } else if ($u_status == "Partial") {
                        $un_status = "Partial";
                     } else if ($u_status == "Error") {
                        $un_status = "Error";
                     } else if ($u_status == "Completed") {
                        $un_status = "Success";
                     } else if ($u_status == "Canceled") {
                        $un_status = "Error";
                     } else {
                         $un_status = "Pending";
                     }

                    $update = Order::find($data->id);
                    $update->status = $un_status;
                    $update->start_count = $u_start;
                    $update->remains = $u_remains;
                    $update->save();
                    echo "SUKSES UPDATE JAP ID ".$update->id;
                    
                    }
                    // print_r($json_result);

                }
            }
        }); 

        // STATUS BULKFOLLOWS
        $schedule->call(function() {
            echo "CHECKING BULKFOLLOWS";
            $provider = Provider::where('name','BULKFOLLOWS')->first();

            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();

                foreach($order as $data_order) {
                    $poid = $data_order->poid;
                    
                    $status = Bulkfollows::status($poid); # return status, charge, remains, start count, currency


                    if(isset($status->status)) {
                        $stat = $status->status;

                        if($stat == 'Completed'){
                            $newstat = "Success";
                        }else if($stat == 'Canceled') {
                            $newstat = 'Error';
                        }else{
                            $newstat = 'Pending';
                        }

                        $update = Order::find($data_order->id);
                        $update->status = $newstat;
                        $update->start_count = $status->start_count;
                        $update->remains = $status->remains;
                        $update->save();
                        echo "SUKSES UPDATE BULKFOLLOWS ID (".$status->status.")  ".$update->id;
                    }
                }
            }
        });
        // STATUS PERFECTSMM
        $schedule->call(function() {
            echo "CHECKING PERFECTSMM";
            $provider = Provider::where('name','PERFECTSMM')->first();
            if($provider) {
                $api_key = $provider->api_key;

                $order = Order::select('orders.id','poid')
                    ->join('services','orders.service_id','services.id')
                    ->where('services.provider_id',$provider->id)
                    ->whereIn('orders.status', ['Pending','Processing'])->get();

                foreach($order as $data_order) {
                    $poid = $data_order->poid;
                    
                    $status = PerfectSMM::status($poid); # return status, charge, remains, start count, currency


                    if(isset($status->status)) {
                        $stat = $status->status;

                        if($stat == 'Completed'){
                            $newstat = "Success";
                        }else if($stat == 'Canceled') {
                            $newstat = 'Error';
                        }else if($stat == 'Partial') {
                            $newstat = 'Partial';
                        }else if($stat == 'In Progress' || $stat == 'Processing') {
                            $newstat = 'Processing';
                        }else{
                            $newstat = 'Pending';
                        }

                        $update = Order::find($data_order->id);
                        $update->status = $newstat;
                        $update->start_count = $status->start_count;
                        $update->remains = $status->remains;
                        $update->save();
                        echo "SUKSES UPDATE PERFECTSMM ID (".$status->status.")  ".$update->id;
                    }
                }
            }
        });
        // CEKMUTASI.CO.ID BCA
        $schedule->call(function() {
            echo "CEMUTASI BCA";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','BANK BCA')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $norek = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::yesterday()->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "service_code"    => "bca",
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });
        // CEKMUTASI.CO.ID BRI
        $schedule->call(function() {
            echo "CEMUTASI BRI";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','BANK BRI')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $norek = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::yesterday()->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "service_code"    => "bca",
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });
        // CEKMUTASI.CO.ID MANDIRI
        $schedule->call(function() {
            echo "CEMUTASI MANDIRI";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','BANK MANDIRI')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $norek = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::yesterday()->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "service_code"    => "mandiri",
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });
        // CEKMUTASI.CO.ID BNI
        $schedule->call(function() {
            echo "CEMUTASI BNI";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','BANK BNI')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $norek = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::yesterday()->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "service_code"    => "bni",
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });

        // CEKMUTASI.CO.ID OVO
        $schedule->call(function() {
            echo "CEKMUTASI OVO";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','OVO')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $no_telp = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::parse($deposit->created_at)->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/ovo/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });
        // CEKMUTASI.CO.ID GOPAY
        $schedule->call(function() {
            echo "CEKMUTASI GOPAY";
            $apikey = env('CEKMUTASI_API_KEY');
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name','deposit_methods.data')
                                ->join('deposit_methods','deposit_methods.id','deposits.method')
                                ->where('deposits.status','Pending')
                                ->where('deposit_methods.name','GOPAY')
                                ->where('deposit_methods.type','AUTO')
                                ->get();
            
            foreach($deposits as $deposit) {
                $no_telp = $deposit->data;
                 $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::parse($deposit->created_at)->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(4)->format('Y-m-d H:i:s')
                                        ),
                                "account_number"  => $no_telp,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );

                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/gopay/search",
                        CURLOPT_POST            => true,
                        CURLOPT_POSTFIELDS      => http_build_query($data),
                        CURLOPT_HTTPHEADER      => ["API-KEY: ".$apikey], // tanpa tanda kurung
                        CURLOPT_SSL_VERIFYHOST  => 0,
                        CURLOPT_SSL_VERIFYPEER  => 0,
                        CURLOPT_RETURNTRANSFER  => true,
                        CURLOPT_HEADER          => false
                    ));
                    $chresult = curl_exec($ch);
                    curl_close($ch);

                    $json_result = json_decode($chresult);
                    var_dump($json_result);
                    if($json_result->success == true) {
                        $update = Deposit::find($deposit->id);
                        $update->status = 'Success';
                        $update->save();

                        $balance_history = new Balance_history;
                        $balance_history->user_id = $deposit->user_id;
                        $balance_history->action = "Add Balance";
                        $balance_history->quantity = $deposit->get_balance;
                        $balance_history->desc = "Deposit id ".$deposit->id." sukses Rp ".$deposit->get_balance;
                        $balance_history->save();

                        $user = User::find($deposit->user_id);
                        $user->balance = $user->balance + $deposit->get_balance;
                        $user->save();

                        echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                    } 
            }
        });



        
           
    }



    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
