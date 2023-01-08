<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Order;
use App\Orders_pulsa;
use App\News;
use App\Provider;
use App\Staff;
use App\Oprator;
use App\Activity;
use App\Balance_history;
use App\Deposit;
use App\Ticket;
use App\Ticket_content;
use App\Deposit_method;
use App\Invitation_code;
use App\Custom_price;
use Alert;
use Carbon\Carbon;

class AdminController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}
    
    public function index(){
        $data['order_sosmed_alltime'] = DB::table('orders')->select(DB::raw("COUNT('orders.*') as total_order"), DB::raw('SUM(services.keuntungan)/1000*orders.quantity as keuntungan'), DB::raw('SUM(orders.price) as total_price'))
            ->join('services','services.id','orders.service_id')
            ->get();
        $data['order_sosmed_alltime']['pending'] = Order::where('status','Pending')->count();
        $data['order_sosmed_alltime']['processing'] = Order::whereIn('status',['Processing'])->count();
        $data['order_sosmed_alltime']['success'] = Order::where('status','Success')->count();
        $data['order_sosmed_alltime']['error'] = Order::whereIn('status',['Error','Partial'])->count();
        $data['order_sosmed_alltime']['refund'] = DB::table('orders')->select(DB::raw("SUM(price) as quantity"))->where('refund',1)->first();
        $keuntungan_sosmed_alltime = Order::where('status','!=','Error')->get();
        $keuntungan = 0;
        foreach($keuntungan_sosmed_alltime as $data_order) {
            $keuntungans = $data_order->service->keuntungan / 1000 * $data_order->quantity;
            $keuntungan += $keuntungans;
        }
        $data['order_sosmed_alltime']['keuntungan'] = $keuntungan;

        $data['order_sosmed_thismo'] = DB::table('orders')->select(DB::raw("COUNT('orders.*') as total_order"), DB::raw('SUM(services.keuntungan) as keuntungan'),DB::raw('SUM(orders.price) as total_price'))
            ->join('services','services.id','orders.service_id')
            ->whereRaw("MONTH(orders.created_at) = ".date('m'))
            ->get();
        $data['order_sosmed_thismo']['pending'] = DB::table("orders")->where('status','Pending')->whereRaw("MONTH(orders.created_at) = ".date('m'))->count();
        $data['order_sosmed_thismo']['processing'] = DB::table("orders")->whereIn('status',['Processing'])->whereRaw("MONTH(orders.created_at) = ".date('m'))->count();
        $data['order_sosmed_thismo']['success'] = DB::table("orders")->where('status','Success')->whereRaw("MONTH(orders.created_at) = ".date('m'))->count();
        $data['order_sosmed_thismo']['error'] = DB::table("orders")->whereIn('status',['Error','Partial'])->whereRaw("MONTH(orders.created_at) = ".date('m'))->count();
        $data['order_sosmed_thismo']['refund'] = DB::table('orders')->select(DB::raw("SUM(price) as quantity"))->where('refund',1)->whereRaw("MONTH(orders.created_at) = ".date('m'))->first();
        $data['order_sosmed_thismo']['lastmo'] = Order::whereRaw('MONTH(created_at) ='.Carbon::now()->subMonth()->format('m'))->count();
        $keuntungan_sosmed_thismo = Order::where('status','!=','Error')->whereRaw('MONTH(created_at) ='.Carbon::now()->format('m'))->get();
        $keuntungan = 0;
        foreach($keuntungan_sosmed_thismo as $data_order) {
            $keuntungans = $data_order->service->keuntungan / 1000 * $data_order->quantity;
            $keuntungan += $keuntungans;
        }
        $data['order_sosmed_thismo']['keuntungan'] = $keuntungan;


        $data['order_pulsa_alltime'] = DB::table('order_pulsas')->select(DB::raw("COUNT('order_pulsas.*') as total_order"), DB::raw('SUM(order_pulsas.price) as total_price'))
            ->join('service_pulsas','order_pulsas.service_id','service_pulsas.id')
            ->get();
        $data['order_pulsa_alltime']['keuntungan'] = DB::table('order_pulsas')->select(DB::raw('SUM(service_pulsas.keuntungan) as keuntungan'))
            ->join('service_pulsas','order_pulsas.service_id','service_pulsas.id')
            ->where('order_pulsas.status','!=','Error')
            ->first();
        $data['order_pulsa_alltime']['pending'] = Orders_pulsa::where('status','Pending')->count();
        $data['order_pulsa_alltime']['success'] = Orders_pulsa::where('status','Success')->count();
        $data['order_pulsa_alltime']['error'] = Orders_pulsa::whereIn('status',['Error','Partial'])->count();
        $data['order_pulsa_alltime']['refund'] = DB::table('order_pulsas')->select(DB::raw("SUM(price) as price"))->where('refund',1)->first();


        $data['order_pulsa_thismo'] = DB::table('order_pulsas')->select(DB::raw("COUNT('order_pulsas.*') as total_order"), DB::raw('SUM(service_pulsas.keuntungan) as keuntungan'), DB::raw("SUM(order_pulsas.price) AS total_price"))
            ->join('service_pulsas','order_pulsas.service_id','service_pulsas.id')
            ->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))
            ->get();
        $data['order_pulsa_thismo']['keuntungan'] = DB::table('order_pulsas')->select(DB::raw('SUM(service_pulsas.keuntungan) as keuntungan'))
            ->join('service_pulsas','order_pulsas.service_id','service_pulsas.id')
            ->where('order_pulsas.status','!=','Error')
            ->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))
            ->first();
        $data['order_pulsa_thismo']['pending'] = Orders_pulsa::where('status','Pending')->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))->count();
        $data['order_pulsa_thismo']['success'] = Orders_pulsa::where('status','Success')->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))->count();
        $data['order_pulsa_thismo']['error'] = Orders_pulsa::whereIn('status',['Error','Partial'])->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))->count();
        $data['order_pulsa_thismo']['refund'] = DB::table('order_pulsas')->select(DB::raw("SUM(price) as price"))->where('refund',1)->whereRaw("MONTH(order_pulsas.created_at) = ".date('m'))->first();
        $data['order_pulsa_thismo']['lastmo'] = DB::table('order_pulsas')->whereRaw('MONTH(created_at) ='.Carbon::now()->subMonth()->format('m'))->count();

        $data['member']['active'] = DB::table('users')->where('status','Active')->count();
        $data['member']['total_saldo'] = DB::table('users')->select(DB::raw('SUM(balance) as balance'))->where('status','Active')->where('level','!=','Developer')->first();
        $data['member']['penggunaan_saldo'] = DB::table('balance_histories')->select(DB::raw('SUM(quantity) as quantity'))->whereRaw("MONTH(balance_histories.created_at) = ".date('m'))->where('action','Cut Balance')->first();
        $data['member']['register_thismo'] = DB::table('users')->whereRaw('MONTH(created_at) = '.date('m'))->count();
        $data['member']['balance_total'] = DB::table('users')->select(DB::raw("SUM(balance) as balance"))->where('level','!=','Developer')->first();
        $data['member']['count'] = User::count();

        $data['services']['sosmed']['total'] = Service::count();
        $data['services']['pulsa']['total'] = Services_pulsa::count();
        return view('developer.index', $data);
    }
    public function report(){}
  

    public function activity() {
        $activities =  Activity::orderBy('id','desc')->simplePaginate(5);
        $balance_histories = Balance_history::orderBy('id','desc')->simplePaginate(5);
        return view('developer.activity', compact('activities','balance_histories'));
    }
}
