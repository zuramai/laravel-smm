<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Alert;
use App\Order;
use App\Service;
use App\Orders_pulsa;
use App\News;
use App\Voucher;
use App\Staff;
use App\Activity;
use App\Balance_history;
use App\User;
use Carbon\Carbon;
use App\Helpers\Envaya\EnvayaSMS;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $installedLogFile = storage_path('installed');

        $dateStamp = date("Y/m/d h:i:sa");

        if (!file_exists($installedLogFile))
        {
            return redirect('install');
        }
        if(!Auth::check()){
            return redirect('/landing');
        }
        $data['all'] = Order::where('user_id',Auth::user()->id)->whereIn('status',['Success','Processing','Pending'])->sum('price');
        
        // CARD 1
        $data['total_order_thismo'] = Order::whereRaw('MONTH(created_at) ='.Carbon::now()->format('m'))->where('user_id',Auth::user()->id)->count();
        $data['total_order_lastmo'] = Order::whereRaw('MONTH(created_at) ='.Carbon::now()->subMonth()->format('m'))->where('user_id',Auth::user()->id)->count();
        if($data['total_order_thismo']==0 && $data['total_order_lastmo'] ==0){
            $data['order_percentage'] = $data['total_order_thismo'];
            $data['total_order_thismo'] = 0;
            $data['total_order_lastmo'] = 0;
        }else{
            $data['order_percentage'] = ($data['total_order_thismo'] / ($data['total_order_lastmo']!=0?:1) == 1 ? 0 : ($data['total_order_thismo']/($data['total_order_lastmo']!=0?:1))*100);
            
        }

        // CARD 2
        $data['used_balance'] = Balance_history::where('user_id',Auth::user()->id)->where('action','Cut Balance')->sum('quantity');

        // CARD 3
        $data['last_used_balance'] = Balance_history::where('user_id',Auth::user()->id)->where('action','Cut Balance')->orderBy('id','desc')->first();
        $data['balance_usage_thismo'] = Balance_history::where('user_id',Auth::user()->id)->whereRaw('MONTH(created_at) = '.Carbon::now()->format('m'))->sum('quantity');
        $data['balance_usage_lastmo'] = Balance_history::where('user_id',Auth::user()->id)->whereRaw('MONTH(created_at) = '.Carbon::now()->subMonth()->format('m'))->sum('quantity');
        if($data['balance_usage_thismo']==0 && $data['balance_usage_lastmo']==0){
            $data['balance_percentage'] = 0;
        }else{
            $data['balance_percentage'] = ($data['balance_usage_thismo']/$data['balance_usage_lastmo'])*100;
        }

        $data['total_order'] = Order::where('user_id',Auth::user()->id)->get();
        $data['pendingprocessing'] = Order::where('user_id',Auth::user()->id)->whereIn('status',['Pending','Processing'])->count();
        $data['pending'] = Order::where('user_id',Auth::user()->id)->where('status','Pending')->count();
        $data['processing'] = Order::where('user_id',Auth::user()->id)->whereIn('status',['Processing'])->count();
        $data['success'] = Order::where('user_id',Auth::user()->id)->where('status','Success')->count();
        $data['user'] = User::where('id',Auth::user()->id)->first();
        $data['top3'] = DB::select("select  user_id, users.name, users.photo, SUM(price) AS total_order FROM orders JOIN users ON users.id = user_id GROUP BY orders.user_id ORDER BY total_order   DESC");

        $data['sosmed']['6_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(6)->format('Y-m-d').'%')->count();
        $data['sosmed']['5_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(5)->format('Y-m-d').'%')->count();
        $data['sosmed']['4_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(4)->format('Y-m-d').'%')->count();
        $data['sosmed']['3_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(3)->format('Y-m-d').'%')->count();
        $data['sosmed']['2_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(2)->format('Y-m-d').'%')->count();
        $data['sosmed']['1_days_ago'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(1)->format('Y-m-d').'%')->count();
        $data['sosmed']['now'] = Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->format('Y-m-d').'%')->count();
        // dd(Carbon::now()->subDays(1)->format('Y-m-d'));
        // dd( Order::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(1)->format('Y-m-d').'%')->count() );

        $data['pulsa']['6_days_ago'] = Orders_pulsa::where('created_at','LIKE','%'.Carbon::now()->subDays(6)->format('Y-m-d').'%')->count();
        $data['pulsa']['5_days_ago'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(5)->format('Y-m-d').'%')->count();
        $data['pulsa']['4_days_ago'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(4)->format('Y-m-d').'%')->count();
        $data['pulsa']['3_days_ago'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(3)->format('Y-m-d').'%')->count();
        $data['pulsa']['2_days_ago'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(2)->format('Y-m-d').'%')->count();
        $data['pulsa']['1_days_ago'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->subDays(1)->format('Y-m-d').'%')->count();
        $data['pulsa']['now'] = Orders_pulsa::where('user_id',Auth::user()->id)->where('created_at','LIKE','%'.Carbon::now()->format('Y-m-d').'%')->count();

        $data['order_sosmed'] = DB::select("SELECT MONTH(created_at) as month, count(*) as total FROM orders GROUP BY MONTH(created_at) ");
        $data['order_pulsa'] = DB::select("SELECT MONTH(created_at) as month, count(*) as total FROM orders_pulsas GROUP BY MONTH(created_at) ");

        return view('dashboard', $data);
    }

    public function landing() {
        $data['total_layanan'] = Service::count();
        $data['total_pengguna'] = User::count();
        $data['total_pesanan'] = Order::count();
        return view('landing', $data);
    }

    public function read_news(Request $r) {
        session(['display_news'=>false]);
    }

    

    public function hof() {
        $top_sosmed = DB::select("SELECT users.id as user_id, users.name, SUM(price) AS price, COUNT(orders.id) AS jumlah, orders.created_at from orders  join users on orders.user_id = users.id WHERE orders.created_at LIKE '%".date('Y-m')."%' group by user_id order by price desc LIMIT 10");

        $top_pulsa = DB::select("SELECT orders_pulsas.user_id, users.name, SUM(orders_pulsas.price) AS price,COUNT(orders_pulsas.id) AS jumlah, orders_pulsas.created_at FROM orders_pulsas JOIN users ON users.id = orders_pulsas.user_id WHERE orders_pulsas.created_at LIKE '%".date('Y-m')."%' AND orders_pulsas.status='Success' GROUP BY user_id ORDER BY price DESC LIMIT 10");

        $top_layanan = DB::select('SELECT COUNT(*) as jumlah_order, services.name FROM orders JOIN services ON services.id = orders.service_id  GROUP BY orders.service_id ORDER BY jumlah_order DESC LIMIT 10');
        
        $top_deposit = DB::select('SELECT COUNT(*) as count_deposit, SUM(deposits.quantity) as total_deposit, users.name FROM deposits JOIN users ON deposits.user_id = users.id WHERE deposits.status = "Success" ORDER BY total_deposit  LIMIT 10');
        
        return view('others.hall_of_fame', compact('top_sosmed', 'top_pulsa', 'top_layanan','top_deposit'));
    }

    public function activity() {
        $activities = Activity::where('user_id',auth()->user()->id)->orderBy('id','desc')->simplePaginate(10);
        return view('others.activity', compact('activities'));
    }

    public function balance_usage() {
        $balance_histories = Balance_history::where('user_id',auth()->user()->id)->orderBy('id','desc')->simplePaginate(10);
        return view('others.balance_usage', compact('balance_histories'));
    }

    public function contact() {
        $staff = Staff::orderBy('id','asc')->get();
        return view('others.contact', compact('staff'));
    }

    public function news() {
        $news = News::orderBy('id','desc')->simplePaginate(10);
        return view('others.news',compact('news'));
    }

    public function voucher() {
        return view('others.voucher');
    }

    public function voucher_post(Request $r) {
        $r->validate([
            'code' => 'required',
        ]);

        $code = $r->code;

        $checkCode = Voucher::where('code',$code)->first();
        if(!$checkCode || $checkCode->status == 'Used') {
            Alert::error('Error');
            session()->flash('danger','Kode voucher tidak ada atau telah digunakan');
            return redirect()->back();
        }

        $checkCode->status = 'Used';
        $checkCode->save();

        $user = User::find(Auth::user()->id);
        $user->balance += $checkCode->quantity;
        $user->save();

        $balance_history = new Balance_history;
        $balance_history->user_id = Auth::user()->id;
        $balance_history->quantity = $checkCode->quantity;
        $balance_history->action = "Add Balance";
        $balance_history->desc = "Claim kode voucher senilai Rp ".number_format($checkCode->quantity);
        $balance_history->save();
        
        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->type = "Claim Voucher";
        $activity->description = "Claim kode voucher senilai Rp ".number_format($r->quantity);
        $activity->user_agent = $r->header('User-Agent');
        $activity->ip = $r->ip();
        $activity->save();

        Alert::success('Sukses input voucher!','Sukses!');
        session()->flash('success','Sukses claim voucher! <br> Jumlah saldo ditambahkan: Rp '.number_format($checkCode->quantity)." <br> Jumlah saldo sekarang: ".number_format($user->balance));
        return redirect()->back();

    }

    public function returnHome() {
        return redirect('/');
    }

    public function gateway_tsel(Request $r) {
        $PASSWORD = env('ENVAYASMS_TSEL_PASSWORD','qwerty1234');
        $OUTGOING_DIR_NAME = __DIR__."/outgoing_sms";
        $AMQP_SETTINGS = array(
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'password' => 'guest',
            'vhost' => '/',
            'queue_name' => "envayasms"
        );

        
        $request = EnvayaSMS::get_request();
        header("Content-Type: {$request->get_response_type()}");
        if (!$request->is_validated($PASSWORD))
        {
            header("HTTP/1.1 403 Forbidden");
            error_log("Invalid password");    
            echo $request->render_error_response("Invalid password");
            return;
        }
        $action = $request->get_action();
        switch ($action->type)
        {
            case EnvayaSMS::ACTION_INCOMING:    
                
                // Send an auto-reply for each incoming message.
            
                $type = strtoupper($action->message_type);
                $isi_pesan = $action->message;
             if($action->from == '858' AND preg_match("/Anda mendapatkan penambahan pulsa/i", $isi_pesan)) {
                 $pesan_isi = $action->message;
                 $insert_order = mysqli_query($db, "INSERT INTO pesan_tsel (isi, status, date) VALUES ('$pesan_isi', 'UNREAD', '$date')");
                 $check_history_topup = mysqli_query($db, "SELECT * FROM history_topup WHERE status = 'NO' AND provider = 'TSEL' AND date = '$date'");
                 if (mysqli_num_rows($check_history_topup) == 0) {
                        error_log("History TopUp Not Found .");
                 } else {
                     while($data_history_topup = mysqli_fetch_assoc($check_history_topup)) {
                                $id_history = $data_history_topup['id'];
                                $no_pegirim = $data_history_topup['no_pengirim'];
                                $username_user = $data_history_topup['username'];
                                $amount = $data_history_topup['amount'];
                                $date_transfer = $data_history_topup['date'];
                                $date_type = $data_history_topup['type'];
                                $jumlah_transfer = $data_history_topup['jumlah_transfer'];
                                $cekpesan = preg_match("/Anda mendapatkan penambahan pulsa Rp $jumlah_transfer dari nomor $no_pegirim tgl $date_transfer/i", $isi_pesan);
                                if($cekpesan == true) {
                                    
                                    if($date_type == 'WEB') {
                                    $update_history_topup = mysqli_query($db, "UPDATE history_topup SET status = 'YES' WHERE id = '$id_history'");
                                    $update_history_topup = mysqli_query($db, "UPDATE users SET balance = balance+$amount WHERE username = '$username_user'");
                                    $update_history_topup = mysqli_query($db, "UPDATE users SET smsnotif = '0' WHERE username = '$post_username'"); 
                                    } 
                                    if($update_history_topup == TRUE) {
                                        error_log("Saldo $username_user Telah Ditambahkan Sebesar $amount");
                                    } else {
                                        error_log("System Error");
                                    }
                                } else {
                                    error_log("data Transfer Pulsa Tidak Ada");
                                }
                        }
                 }
             } else {
                error_log("Received $type from {$action->from}");
                error_log(" message: {$action->message}");
             }                     
                
                return;
        }
    }



}
