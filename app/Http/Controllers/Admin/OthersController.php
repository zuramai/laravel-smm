<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\Environtment;
use App\Helpers\Numberize;
use App\Helpers\EnvayaSMS\EnvayaSMS;
use App\Http\Controllers\Controller;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Activity;
use App\Balance_history;
use App\Custom_price;
use App\SMSLog;
use App\Deposit;
use Carbon\Carbon;
use App\Config;
use Alert;
use Auth;
use DB;
use Log;


class OthersController extends Controller
{
    public function custom_price() {
        $custom_prices = Custom_price::orderBy('id','DESC')->simplePaginate(15);
        return view('developer.custom_price', compact('custom_prices'));
    }

    public function custom_price_post(Request $r) {
        $r->validate([
            'email' => 'required',
            'serviceid' => 'required|exists:services,id',
        ],[
            'serviceid.exists' => 'Layanan tidak ditemukan'
        ]);

        $email = $r->email;

        $sid = $r->serviceid;
        $service = Service::find($r->serviceid);
        $total_price = $service->price+$service->keuntungan;
        $r->validate([
            'potongan' => ['required','max:'.$total_price]
        ],[
            'potongan.min' => 'Jumlah potongan tidak boleh melebihi harga layanan'
        ]);
        $potongan = $r->potongan;

        // GET USER ID
        $user = User::where('email',$email)->orWhere('username',$email)->first();
        if(!$user) {
            session()->flash('danger','Email atau username tidak ditemukan');
            return redirect()->back();
        }
        $user_id = $user->id;

        $ins = new Custom_price;
        $ins->user_id = $user_id;
        $ins->service_id = $sid;
        $ins->potongan = $potongan;
        $ins->save();

        session()->flash('success',"Sukses tambah data! <br><b>Email:</b> $email<br> <b>Service:</b> $sid<br> <b>Jumlah Potongan:</b> $potongan");
        Alert::success('Sukses tambah data!','Sukses');
        return redirect()->back();
    }

    public function custom_price_delete(Request $r) {
        $r->validate([
            'id'=>'required|exists:custom_prices,id'
        ]);
        $id = $r->id;

        Custom_price::find($id)->delete();
        session()->flash('success','Sukses hapus data!');
        Alert::success('Sukses hapus!','success');
        return redirect()->back();
    }


    public function configuration() {
        return view('developer.configuration.index');   
    }

    public function configuration_update(Request $r) {
        $r->validate([
            'web_title' => 'required',
            'web_description' => 'required',
            'login_desc' => 'required',
            
            'currency_code' => 'required',

            'add_member_price' => 'required|integer|min:0',
            'add_agen_price' => 'required|integer|min:0',
            'add_reseller_price' => 'required|integer|min:0',
            'add_admin_price' => 'required|integer|min:0',

            'member_balance' => 'required|integer|min:0',
            'agen_balance' => 'required|integer|min:0',
            'reseller_balance' => 'required|integer|min:0',
            'admin_balance' => 'required|integer|min:0',

            'min_voucher' => 'required|integer|min:0',
            'max_voucher' => 'required|integer|min:0',
            'min_deposit' => 'required|integer|min:0',

            'web_logo' => 'nullable|image',
            'web_logo_dark' => 'nullable|image',
            'favicon' => 'nullable|image',

        ]); 

        $login_desc = str_replace(["\n","\r"],"",$r->login_desc);;
        $login_desc = str_replace(["                                            "],"",$login_desc);
        $login_desc = str_replace('"',"'",$login_desc);;

        if($r->file('web_logo') != null) {
            $photoname = Str::random(10);
            $web_logo_url = $r->file('web_logo')->move(public_path('img/logo'), $photoname);
            $logo_url = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_LOGO_URL"],['value'=>$logo_url]);
        }
        if($r->file('web_logo_dark') != null) {
            $photoname = Str::random(10);
            $web_logo_url_dark = $r->file('web_logo_dark')->move(public_path('img/logo'), $photoname);
            $logo_url_dark = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_LOGO_URL_DARK"],['value'=>$logo_url_dark]);
        }
        if($r->file('favicon') != null) {
            $photoname = Str::random(10);
            $favicon = $r->file('favicon')->move(public_path('img/logo'), $photoname);
            $favicon_url = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_FAVICON_URL"],['value'=>$favicon_url]);
        }

        Config::updateOrCreate(['name'=>"APP_NAME"],['value'=>$r->web_name]);
        Config::updateOrCreate(['name'=>"WEB_TITLE"],['value'=>$r->web_title]);
        Config::updateOrCreate(['name'=>"WEB_DESCRIPTION"],['value'=>$r->web_description]);
        Config::updateOrCreate(['name'=>'WEB_AUTH_DESCRIPTION'],['value'=>$login_desc]);

        Config::updateOrCreate(['name'=>'CURRENCY_CODE'],['value'=>$r->currency_code]);

        Config::updateOrCreate(['name'=>"ADD_MEMBER_PRICE"],['value'=>$r->add_member_price]);
        Config::updateOrCreate(['name'=>"ADD_AGEN_PRICE"],['value'=>$r->add_agen_price]);
        Config::updateOrCreate(['name'=>"ADD_RESELLER_PRICE"],['value'=>$r->add_reseller_price]);
        Config::updateOrCreate(['name'=>"ADD_ADMIN_PRICE"],['value'=>$r->add_admin_price]);
    
        Config::updateOrCreate(['name'=>"MEMBER_BALANCE"],['value'=>$r->member_balance]);
        Config::updateOrCreate(['name'=>"AGEN_BALANCE"],['value'=>$r->agen_balance]);
        Config::updateOrCreate(['name'=>"RESELLER_BALANCE"],['value'=>$r->reseller_balance]);
        Config::updateOrCreate(['name'=>"ADMIN_BALANCE"],['value'=>$r->admin_balance]);
        
        Config::updateOrCreate(['name'=>"MIN_VOUCHER"],['value'=>$r->min_voucher]);
        Config::updateOrCreate(['name'=>"MAX_VOUCHER"],['value'=>$r->max_voucher]);
        Config::updateOrCreate(['name'=>"MIN_DEPOSIT"],['value'=>$r->min_deposit]);

        
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        session()->flash('success','Sukses mengubah konfigurasi website!');
        return redirect()->back();
    }


    public function envaya() {
        $envaya = new EnvayaSMS;
        $request = $envaya->get_request();
        $PASSWORD = "qwerty1234";
        $today = Carbon::today()->format('Y-m-d H:i:s');
        $todayLastMinute = date('Y-m-d')." 23:59:59";
        Log::info("========== Envaya New Request ============");
        if (!$request->is_validated($PASSWORD))
        {
            header("HTTP/1.1 403 Forbidden");
            error_log("Invalid password");    
            echo $request->render_error_response("Invalid password");
            return;
        }
        $action = $request->get_action();

        if($action->type == EnvayaSMS::ACTION_INCOMING) {
            $message = $action->message;
            $isi_pesan = $message;
            $from = $action->from;
            Log::info($message." From: ".$from);
            $json = [
                "events" => [
                    'event'=> 'log',
                    'messages' => [
                        'message' => 'SMS diterima dari '.$from.'. Isi: '.$message
                    ]
                ]
            ];

            if ($from == '858' && preg_match("/Anda mendapatkan penambahan pulsa/i", $message)) {
                $array_message = explode(" ", $message);
                $sent_quantity = $array_message[5];
                $phone_number = $array_message[8];
                Log::info("ENVAYA FROM 858, QUANTITY => $sent_quantity, SENDER => $phone_number");

                $deposit = DB::table('deposits')->select('deposits.*','deposit_methods.name as method_name','deposit_methods.data','deposit_methods.code')
                                        ->join('deposit_methods','deposit_methods.id','deposits.method')
                                        ->where('deposits.status','Pending')
                                        ->where('deposits.sender',$phone_number)
                                        ->where('deposits.quantity',$sent_quantity)
                                        ->where('deposit_methods.name','LIKE','%telkomsel%')
                                        ->where('deposit_methods.type','AUTO')
                                        ->whereBetween('deposits.created_at',[$today,$todayLastMinute])
                                        ->first();
                if($deposit) {
                    $update = Deposit::find($deposit->id);
                    $update->status = 'Success';
                    $update->save();

                    $user = User::find($deposit->user_id);
                    $user->balance += $deposit->get_balance;
                    $user->save();

                    $balance_history = new Balance_history;
                    $balance_history->user_id = $deposit->user_id;
                    $balance_history->action = "Add Balance";
                    $balance_history->quantity = $deposit->get_balance;
                    $balance_history->desc = "Deposit Sukses ID: $deposit->id Melalui ".$deposit->method_name." ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($deposit->get_balance).". Saldo Sekarang: ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($user->balance);
                    $balance_history->save();

                    Log::info("Sukses Deposit ID ".$deposit->id." ".config('web_config')['CURRENCY_CODE']." ".$deposit->get_balance.". Saldo Sekarang: ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($user->balance));
                }

            } else if ($from == '168' && preg_match("/Anda menerima Pulsa dari/i", $isi_pesan)) {
                $array_message = explode(" ", $message);
                $sent_quantity = substr($array_message[6],2);
                $phone_number = $array_message[4];
                
                Log::info("ENVAYA FROM 168");

                $deposit = DB::table('deposits')->select('deposits.*','deposit_methods.name as method_name','deposit_methods.data','deposit_methods.code')
                                        ->join('deposit_methods','deposit_methods.id','deposits.method')
                                        ->where('deposits.status','Pending')
                                        ->where('deposits.sender',$phone_number)
                                        ->where('deposits.quantity',$sent_quantity)
                                        ->where('deposit_methods.name','LIKE','%xl%')
                                        ->where('deposit_methods.type','AUTO')
                                        ->whereBetween('deposits.created_at',[$today,$todayLastMinute])
                                        ->first();

                if($deposit) {
                    $update = Deposit::find($deposit->id);
                    $update->status = 'Success';
                    $update->save();

                    $user = User::find($deposit->user_id);
                    $user->balance += $deposit->get_balance;
                    $user->save();

                    $balance_history = new Balance_history;
                    $balance_history->user_id = $deposit->user_id;
                    $balance_history->action = "Add Balance";
                    $balance_history->quantity = $deposit->get_balance;
                    $balance_history->desc = "Deposit Sukses ID: $deposit->id Melalui ".$deposit->method_name." ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($deposit->get_balance).". Saldo Sekarang: ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($user->balance);
                    $balance_history->save();

                    Log::info("Sukses Deposit ID ".$deposit->id." ".config('web_config')['CURRENCY_CODE']." ".$deposit->get_balance.". Saldo Sekarang: ".config('web_config')['CURRENCY_CODE']." ".Numberize::make($user->balance));
                }
            } else {

            }    
            return response()->json($json, 200);
        }
        
        // switch ($action->type)
        // {
        //     case EnvayaSMS::ACTION_INCOMING:    
                
        //         // Send an auto-reply for each incoming message.
            
        //         $type = strtoupper($action->message_type);
        //         $isi_pesan = $action->message;
        //      if($action->from == '858' AND preg_match("/Anda mendapatkan penambahan pulsa/i", $isi_pesan)) {
        //          $pesan_isi = $action->message;
        //          $insert_order = mysqli_query($db, "INSERT INTO message_tsel (content, status, date) VALUES ('$pesan_isi', 'UNREAD', '$date')");
        //          $check_history_topup = mysqli_query($db, "SELECT * FROM deposits_history WHERE status = 'Pending' AND method = 'Telkomsel' AND date = '$date'");
        //          if (mysqli_num_rows($check_history_topup) == 0) {
        //                 error_log("History TopUp Not Found .");
        //          } else {
        //              while($data_history_topup = mysqli_fetch_assoc($check_history_topup)) {
        //                         $id_history = $data_history_topup['id'];
        //                         $no_pegirim = $data_history_topup['no_pengirim'];
        //                         $username_user = $data_history_topup['user'];
        //                         $amount = $data_history_topup['quantity'];
        //                         $date_transfer = $data_history_topup['date'];
        //                         $get_balance = $data_history_topup['get_balance'];
        //                         $jumlah_transfer = $data_history_topup['jumlah_transfer'];
        //                         $cekpesan = preg_match("/Anda mendapatkan penambahan pulsa ".config('web_config')['CURRENCY_CODE']." $jumlah_transfer dari nomor $no_pegirim tgl $date_transfer/i", $isi_pesan);
        //                         if($cekpesan == true) {
                                    
        //                             $update_history_topup = mysqli_query($db, "UPDATE deposits_history SET status = 'Success' WHERE id = '$id_history'");
        //                             $update_history_topup = mysqli_query($db, "UPDATE users SET balance = balance+$get_balance WHERE username = '$username_user'");
                             
        //                             if($update_history_topup == TRUE) {
        //                                 error_log("Saldo $username_user Telah Ditambahkan Sebesar $get_balance");
        //                             } else {
        //                                 error_log("System Error");
        //                             }
        //                         } else {
        //                             error_log("data Transfer Pulsa Tidak Ada");
        //                         }
        //                 }
        //          }
        //      } else {
        //         error_log("Received $type from {$action->from}");
        //         error_log(" message: {$action->message}");
        //      }                     
                
        //         return;
        // }
    }
}

