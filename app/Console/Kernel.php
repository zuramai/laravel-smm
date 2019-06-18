<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Helpers\FArray;
use App\Deposit;
use App\API;
use App\ApiRequestParam;
use App\ApiRequestHeader;
use App\ApiResponseLog;
use App\Deposit_method;
use App\User;
use App\Order;
use App\Provider;
use App\Orders_pulsa;
use App\Balance_history;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use App\Helpers\Oper\Bulkfollows as Bulkfollows;
use App\Helpers\Oper\PerfectSMM as PerfectSMM;
use App\Helpers\SearchKey;

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
        // STATUS PULSA
        $schedule->call(function() {
            echo "CHECKING PULSA";
            $orders = Orders_pulsa::where('status','Pending')->get();

            if(!$orders){
                return "Order pending not found";
            }

            foreach($orders as $order) {
                echo "CHECKING";
                $poid = $order->poid;

                $api_id = $order->service->provider->api->id;
                $provider_name = $order->service->provider->name;
                $code = $order->service->code;
                $target = $order->target;
                $api = API::findOrFail($api_id);
                $ApiRequestHeader = ApiRequestHeader::where('api_id', $api_id)->where('api_type','status')->pluck('header_value','header_key');
                $ApiRequestParam = ApiRequestParam::where('api_id', $api_id)->where('api_type','status')->pluck('param_value','param_key');
                // dd($ApiRequestParam);
                $url = $api->order_end_point;
            
                # INITIAL HEADERS
                if($provider_name == "PORTALPULSA") {
                    $header = array(
                        'portal-userid: '.$ApiRequestHeader['portal-userid'],
                        'portal-key: '.$ApiRequestHeader['portal-key'], // lihat hasil autogenerate di member area
                        'portal-secret: '.$ApiRequestHeader['portal-secret'], // lihat hasil autogenerate di member area
                    );
                }else{
                    $header = [];
                    foreach($ApiRequestHeader as $key => $value) {
                        $header[$key] = $value;
                    }
                }  

                foreach($ApiRequestParam as $key => $value) {
                    if($value == 'portalpulsa_inquiry') {
                        $inq = "I";
                        if(isset($r->pln)) {
                            $inq = "PLN";
                        }
                        $data[$key] = $inq;
                    }else if($value == 'nometer_pln') {
                        if(isset($r->pln)) {
                            $data[$key] = $r->pln;
                        }
                    }else if($value == 'service_id') {
                        $data[$key] = $code;
                    }else if($value == "phone"){
                        $data[$key] = $target;
                    }else if($value == "portalpulsa_trxid"){
                        $data[$key] = $poid;
                    }else if($value == "portalpulsa_no"){
                        $no = 1;
                        $check = Orders_pulsa::where('data',$target)->where('created_at',Carbon::today()->format('Y-m-d'))->first();
                        if($check) {
                            $no += 1;
                        }
                        $data[$key] = $no;
                    }else{
                        $data[$key] = $value;
                    }
                } 

                # INITIAL PARAMETER
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                $result = curl_exec($ch);
                $json_result = json_decode($result, true);
                print_r($json_result);
                
                // dd($json_result);
                $success_response = FArray::array_cast_recursive(json_decode($api->order_success_response,true));
                $searchStatus = SearchKey::arraySearch($json_result, $api->status_key);
                // Response keys are equal to success response?
                if ($searchStatus) {
                    // Get orderID column from API response
                    $sn = SearchKey::arraySearch($json_result, $api->start_counter_key);
                    if(!$sn) {
                        $sn = SearchKey::arraySearch($json_result, $api->remains_key);
                    }
                    if($provider_name == 'PORTALPULSA') {
                         if ($searchStatus == 1) {
                            $un_status = "Pending";
                         } else if ($searchStatus == 2) {
                            $un_status = "Error";       
                         } else if ($searchStatus == 3) {
                            $un_status = "Partial";
                         } else if ($searchStatus == 4) {
                            $un_status = "Success";
                         } else {
                             $un_status = "Pending";
                         }
                    }else{
                        $un_status = $searchStatus;
                    }

                     $update = Orders_pulsa::find($order->id);
                     $update->status = $un_status;
                     $update->sn = $sn;
                     $update->save(); 

                     echo "ORDER ID => $order->id, Status => $un_status -";
                        ApiResponseLog::create([
                            'order_id' => $order->id,
                            'api_id' => $api_id,
                            'response' => $result
                        ]);
                }else{
                    $sn = $json_result['message'];    
                    $un_status = "Error";
                }
                 echo "ORDER ID => $poid, Status => $un_status -";

            }
        });     

        
        # ============================
        #     AUTO STATUS & REFUND
        # ===========================
        $schedule->call(function() {
            echo "CHECKING SOSMED";
            $orders = Order::whereIn('status', ['Pending', 'Processing'])->inRandomOrder()->limit(15)->get();
            if (!$orders->isEmpty()) {

                foreach ($orders as $order) {
                    $api = API::find($order->service->provider->api_id);

                    // Build api request parameters
                    $params = [];
                    $apiRequestParams = ApiRequestParam::where(['api_id' => $api->id, 'api_type' => 'status'])->get();
                    if (!$apiRequestParams->isEmpty()) {

                        foreach ($apiRequestParams as $row) {
                            if ($row->param_type === 'custom') {
                                $params[$row->param_key] = $row->param_value;
                            } else {
                                if($row->param_value == "id") {
                                    $params[$row->param_key] = $order->poid;
                                }
                            }
                        }
                        $params[$api->order_id_key] = $order->poid;
                        // create new client and make call
                        $client = new Client();
                        try {

                            $param_key = 'form_params';
                            if ($api->status_method === 'GET') {
                                $param_key = 'query';
                            }

                            $res = $client->request($api->status_method, $api->status_end_point, [
                                $param_key => $params,
                                'headers' => ['Accept' => 'application/json'],
                            ]);

                            if ($res->getStatusCode() === 200) {

                                $resp = $res->getBody()->getContents();
                                $json_result = json_decode($resp,true);
                                $status = SearchKey::arraySearch($json_result, $api->status_key);
                                if($status == true || $status == false) {
                                    unset($json_result[$api->status_key]);
                                }
                                $status = SearchKey::arraySearch($json_result, $api->status_key);
                                // Response keys are equal to success response?
                                if ($status) {
                                    $start_count = SearchKey::arraySearch($json_result, $api->start_counter_key);
                                    $remains = SearchKey::arraySearch($json_result, $api->remains_key);
                                    // Get orderID column from API response
                                    $ress = json_decode($resp, true);
                                    // 'status' key is present in array?
                                    if ($status) {
                                        if (strtoupper(trim($status)) == 'COMPLETED' || strtoupper(trim($status)) == 'COMPLETE' || strtoupper(trim($status)) == 'SUCCESS') {
                                            Order::find($order->id)->update([
                                                'status' => 'Success',
                                                'start_count' => $start_count,
                                                'remains' => $remains,
                                            ]);
                                        } elseif (strtoupper(trim($status)) == 'PENDING'
                                            || strtoupper(trim($status)) == 'INPROGRESS'
                                            || strtoupper(trim($status)) == 'IN_PROGRESS'
                                            || strtoupper(trim($status)) == 'IN-PROGRESS'
                                            || strtoupper(trim($status)) == 'IN PROGRESS'
                                            || strtoupper(trim($status)) == 'PROCESSING'
                                            || strtoupper(trim($status)) == 'PROGRESS') {
                                            // do nothing with status but update the start_count
                                            Order::find($order->id)->update([
                                                'status' => 'Processing',
                                                'start_count' => $start_count,
                                                'remains' => $remains,
                                            ]);
                                        } elseif (in_array(strtoupper(trim($status)), ['PARTIAL', 'PARTIALLY', 'PARTIALLY COMPLETED', 'PARTIAL COMPLETE'])) {

                                            if (isset($remains) && $remains > 0) {

                                                $remains = $remains;
                                                $quantity = $order->quantity;
                                                $orderPrice = $order->price;
                                                $user = User::find($order->user_id);
                                                $price = $order->service->price;                                            

                                              


                                                if ($remains < $quantity) {
                                                    // Order price to .00 decimal points
                                                    $bagi = $remains / $quantity;
                                                    $refundAmount = $price * $bagi;

                                                    if ($refundAmount > 0) {
                                                        // decrease amount in order price
                                                        $orderPrice = $price - $refundAmount;

                                                        // Refund partial to user account
                                                        $user->balance = $user->balance + $refundAmount;
                                                        $user->save();

                                                        $balance_history = new Balance_history;
                                                        $balance_history->user_id = $user->id;
                                                        $balance_history->action = "Refund";
                                                        $balance_history->quantity = $refundAmount;
                                                        $balance_history->desc = "Saldo Dikembalikan Sebesar Rp ".number_format($refundAmount)." Untuk Pemesanan Sosial Media ID #".$order->id;
                                                        $balance_history->save();

                                                        // do nothing with status but update the start_count
                                                        Order::find($order->id)->update([
                                                            'start_count' => $start_count,
                                                            'status' => 'Partial',
                                                            'remains' => $remains,
                                                            'price' => $orderPrice,
                                                            'refund' => 1
                                                        ]);
                                                    }else{
                                                        Order::find($order->id)->update([
                                                            'status' => 'Partial',
                                                            'remains' => $remains,
                                                            'refund' => 1,
                                                        ]);
                                                    }

                                                }elseif($remains >=   $quantity){
                                                    // Refund partial to user account
                                                        $user->balance = $user->balance + $order->price;
                                                        $user->save();

                                                        $balance_history = new Balance_history;
                                                        $balance_history->user_id = $user->id;
                                                        $balance_history->action = "Refund";
                                                        $balance_history->quantity = $order->price;
                                                        $balance_history->desc = "Saldo Dikembalikan Sebesar Rp ".number_format($order->price)." Untuk Pemesanan Sosial Media ID #".$order->id;
                                                        $balance_history->save();

                                                        // do nothing with status but update the start_count
                                                        Order::find($order->id)->update([
                                                            'start_count' => $start_count,
                                                            'status' => 'Error',
                                                            'remains' => $remains,
                                                            'refund' => 1,
                                                        ]);
                                                } 

                                            }

                                        } elseif (in_array(strtoupper(trim($status)), [
                                            'CANCEL',
                                            'CANCELLED',
                                            'CANCELED',
                                            'ERROR',
                                        ])) {

                                            if ($api->process_all_order) {
                                                $user = User::find($order->user_id);
                                                $user->balance = $user->balance + $order->price;
                                                $user->save();

                                                $balance_history = new Balance_history;
                                                $balance_history->user_id = $user->id;
                                                $balance_history->action = "Refund";
                                                $balance_history->quantity = $order->price;
                                                $balance_history->desc = "Saldo Dikembalikan Sebesar Rp ".number_format($order->price)." Untuk Pemesanan Sosial Media ID #".$order->id;
                                                $balance_history->save();

                                                Order::find($order->id)->update([
                                                    'start_count' => $start_count,
                                                    'remains' => $remains,
                                                    'status' => 'Error',
                                                    'refund' => 1,
                                                ]);
                                            }
                                        } elseif (in_array(strtoupper(trim($status)), [
                                            'REFUND',
                                            'REFUNDED'
                                        ])) {

                                            if ($api->process_all_order) {
                                                $user = User::find($order->user_id);
                                                $user->balance = $user->balance + $order->price;
                                                $user->save();

                                                $balance_history = new Balance_history;
                                                $balance_history->user_id = $user->id;
                                                $balance_history->action = "Refund";
                                                $balance_history->quantity = $order->price;
                                                $balance_history->desc = "Saldo Dikembalikan Sebesar Rp ".number_format($order->price)." Untuk Pemesanan Sosial Media ID #".$order->id;
                                                $balance_history->save();

                                                Order::find($order->id)->update([
                                                    'start_count' => $start_count,
                                                    'remains' => $remains,
                                                    'status' => 'Error',
                                                    'refund' => 1,
                                                ]);
                                            }
                                        }
                                    }
                                }
                                ApiResponseLog::create([
                                    'order_id' => $order->id,
                                    'api_id' => $api->id,
                                    'response' => $resp
                                ]);
                            }
                        } catch
                        (ClientException $e) {

                            ApiResponseLog::create([
                                'order_id' => $order->id,
                                'api_id' => $api->id,
                                'response' => $e->getMessage()
                            ]);

                        }
                    }
                }
            }
        });
        
        
        # ====================
        #     CEKMUTASI
        # ====================
        $schedule->call(function() {
            $apikey = env('CEKMUTASI_API_KEY');
            $today = Carbon::today()->format('Y-m-d H:i:s');
            $todayLastMinute = date('Y-m-d')." 23:59:59";
            $deposits = DB::table('deposits')->select('deposits.*','deposit_methods.name as method_name','deposit_methods.data','deposit_methods.code')
                                    ->join('deposit_methods','deposit_methods.id','deposits.method')
                                    ->where('deposits.status','Pending')
                                    ->whereNotIn('deposit_methods.code',['pulsa'])
                                    ->where('deposit_methods.type','AUTO')
                                    ->whereBetween('deposits.created_at',[$today,$todayLastMinute])
                                    ->get();
            foreach($deposits as $deposit) {
                $norek = $deposit->data;

                $data = array(
                        "search"  => array(
                                "date"            => array(
                                        "from"    => Carbon::parse($deposit->created_at)->format('Y-m-d H:i:s'),
                                        // "from"    => date('Y-m-d H:i:s',strtotime($deposit->created_at)),
                                        "to"      => Carbon::parse($deposit->created_at)->addHours(12)->format('Y-m-d H:i:s')
                                        ),
                                'type' => 'credit',
                                "account_number"  => $norek,
                                "amount"          => $deposit->quantity.".00"
                        )
                    );
                if($deposit->code == 'gopay') {
                    $endpoint = "https://api.cekmutasi.co.id/v1/gopay/search";
                } else if($deposit->code == 'ovo') {
                    $endpoint = "https://api.cekmutasi.co.id/v1/ovo/search";
                    $data['search']['account_number'] = $norek;
                } else {
                    $endpoint = "https://api.cekmutasi.co.id/v1/bank/search";
                    $data['search']['service_code'] = $data->code;
                }
                
                // dd($data);
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL             => $endpoint,
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

                $json_result = json_decode($chresult, true);
                // dd($json_result);

                if( $json_result['success'] === true )
                {
                    if( count($json_result['response']) > 0 )
                    {
                        $firstResponse = $json_result['response'][0];
                        $log = $firstResponse;
                        
                        if( number_format($firstResponse['amount'], 0, '', '') == $deposit->quantity )
                        {   
                            $update = Deposit::find($deposit->id);
                            $update->status = 'Success';
                            $update->save();

                            $balance_history = new Balance_history;
                            $balance_history->user_id = $deposit->user_id;
                            $balance_history->action = "Add Balance";
                            $balance_history->quantity = $deposit->get_balance;
                            $balance_history->desc = "Deposit Sukses Melalui ".$deposit->method_name." Rp ".$deposit->get_balance." (ID: $deposit->id)";
                            $balance_history->save();

                            echo "SUKSES DEPOSIT ID ".$deposit->id. " Nominal => ".$deposit->quantity;
                        }
                    }
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
