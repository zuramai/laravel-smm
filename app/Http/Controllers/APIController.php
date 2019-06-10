<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Order;
use Auth;
use App\User;
use App\Helpers\Order_pulsa as OrderPulsa;
use App\Helpers\Order_sosmed as OrderSosmed;
use App\Activity;
use App\Service_cat;
use App\Services_pulsa;
use App\Provider;
use App\Balance_history;
use App\Orders_pulsa;

class APIController extends Controller
{
    public function sosmed(Request $r) {
    	$key = $r->key;
    	$action = $r->action;
        $list_action = ['order','services','status'];



        if(empty($key) || empty($action)) {
           return response()->json(['error'=>'Incorrect Request']);
        }
     
        $check_key = User::where('api_key',$key)->first();
        

     
        if(!$check_key) {
            return response()->json(['error'=>'Your API Key is not valid']);
        }else if(!in_array($action, $list_action)) {
            return response()->json(['error'=>'Invalid Action']);
        }
        $user_balance = $check_key->balance;
        $user_status = $check_key->status;

        if($user_status == 'Not Active') {
            return response()->json(['error'=>'Akun tidak aktif']);
        }
        // API SERVICES
        if($action == 'services') {
            $services = Service::all(['id','name','category_id','min','max','price','status','note']);
            $array = [];

            foreach($services as $service){
                $array['status'] = 'Success';
                $array['data'][] = array('id'=>$service->id,
                                         'category'=>$service->category->name,
                                         'name'=>$service->name,
                                        'min'=>$service->min,
                                        'max'=>$service->max,
                                        'price'=>$service->price_oper + $service->keuntungan,
                                        'status'=>$service->status,
                                        'note'=>$service->note);
            }
            return response()->json($array);
        }else if($action == 'order') {
            $service = $r->service;
            $post_link = $r->target;
            $post_quantity = $r->quantity;
            $custom_comments = $r->custom_comments;
            $custom_link = $r->custom_link;

            if(empty($service) || empty($post_link) || empty($post_quantity)) {
                return response()->json(['error'=>'Incorrect Request']);
            }

            $check_service = Service::find($service);
            if(empty($check_service)) {
                return response()->json(['error'=>'Invalid Service ID']);
            }

            $service_price = $check_service->price_oper + $check_service->keuntungan;
            $service_min = $check_service->min;
            $service_max = $check_service->max;
            $service_type = $check_service->type;
            $service_status = $check_service->status;
            $service_pid = $check_service->pid;
            $service_provider = $check_service->provider;
            $service_provider_name = $check_service->provider->name;


            if($post_quantity < $service_min) {
                return response()->json(['error'=>'Minimal quantity is '.$service_min]);
            }else if($post_quantity > $service_max) {
                return response()->json(['error'=>'Max quantity is '.$service_max]);
            }else if($service_status == 'Not Active') {
                return response()->json(['error'=>'Layanan tidak aktif']);
            }

            $total_price =  ($check_service->price + $check_service->keuntungan) / 1000 * $r->quantity ;

            $user = User::find($check_key->id);
            if($user->balance < $total_price) {
                Alert::error('Saldo tidak cukup','Error');
                session()->flash('danger','Error: Saldo anda tidak cukup (2) ');
                return redirect()->back();
            }

            
            if($check_service->type == 'custom_comment') {
                $custom_comments = $r->custom_comment;
            }else if($check_service->type == 'comment_likes') {
                $post_links = $r->comment_likes;
            }
            $r->validate([ 
                        'service'=>'required',
                        'quantity'=>"required|integer|min:$service_min|max:$service_max"
                    ],
                    [
                        'service.required'=>'Harap pilih layanan terlebih dahulu!',
                        'quantity.required'=>'Harap isi jumlah terlebih dahulu!',
                        'min'=>'Jumlah minimal adalah $min',
                        'max'=>'Jumlah maksimal adalah $max',
                    ]);
            $api_link = $check_service->provider->link;
            $api_key = $check_service->provider->api_key;

            if($check_service->provider->name == 'IRV'){
                $api_id = env('API_ID_IRV');
                if(isset($r->custom_comments)) {
                    $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $service_pid, $post_link, $post_quantity, $custom_comments);
                }else if(isset($r->custom_link)) {
                    $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $service_pid, $post_link, $post_quantity, false, $post_links);
                }else{
                    $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $service_pid, $post_link, $post_quantity);
                }
            }else if($check_service->provider->name == 'JAP') {
                if(isset($r->custom_comments)) {
                    $order = OrderSosmed::jap($api_key, $service_pid, $post_link, $post_quantity, $custom_comments);
                }else if(isset($r->custom_link)) {
                    $order = OrderSosmed::jap($api_key, $service_pid, $post_link, $post_quantity, false, $post_links);
                }else{
                    $order = OrderSosmed::jap($api_key, $service_pid, $post_link, $post_quantity);
                }
            }else if($check_service->provider->name == 'BULKFOLLOWS') {
                if(isset($r->custom_comments)) {
                    $order = OrderSosmed::bulkfollows($service_pid, $post_link, $post_quantity, $custom_comments);
                }else if(isset($r->custom_link)) {
                    $order = OrderSosmed::bulkfollows($service_pid, $post_link, $post_quantity, false, $post_links);
                }else{
                    $order = OrderSosmed::bulkfollows($service_pid, $post_link, $post_quantity);
                }
            }else if($check_service->provider->name == 'PERFECTSMM') {
                if(isset($r->custom_comment)) {
                    $order = OrderSosmed::perfectsmm($service_pid, $post_link, $post_quantity, $custom_comments);
                }else if(isset($r->custom_link)) {
                    $order = OrderSosmed::perfectsmm($service_pid, $post_link, $post_quantity, false, $post_links);
                }else{
                    $order = OrderSosmed::perfectsmm($service_pid, $post_link, $post_quantity);
                }
            }else if($check_service->provider->name == 'MANUAL') {
                if(isset($r->custom_comments)) {
                    $order = OrderSosmed::manual($service_pid, $post_link, $post_quantity, $custom_comments);
                }else if(isset($r->custom_link)) {
                    $order = OrderSosmed::manual($service_pid, $post_link, $post_quantity, false, $post_links);
                }else{
                    $order = OrderSosmed::manual($service_pid, $post_link, $post_quantity);
                }
            }else if($data_service->provider->name == 'VIPMEMBER') {
                if(isset($r->custom_comment)) {
                    $order = OrderSosmed::vipmember($pid, $post_link, $post_quantity, $custom_comments);
                }else{
                    $order = OrderSosmed::vipmember($pid, $post_link, $post_quantity);
                }
            }else if($data_service->provider->name == 'SMMINDO') {
                $order = OrderSosmed::smmindo($pid, $post_link, $post_quantity);
            }else{
                $order['status'] = false;
                $order['message'] = "Layanan tidak tersedia";
            }
            
            
            if($order['status'] == false){
                return response()->json(['error'=>'Server maintenance']);
            }
            

            $poid = $order["order_id"];    
            $order = new Order;
            $order->poid = $poid;
            $order->user_id = $check_key->id;
            $order->service_id = $service;
            $order->target = $post_link;
            $order->quantity = $post_quantity;
            $order->start_count = 0;
            $order->remains = $post_quantity;
            $order->price = $total_price;
            $order->status = 'Pending';
            $order->place_from = 'WEB';
            $order->notes = "-";
            $order->refund = 0;
            $order->save();

            
            $user->balance = $user->balance - $total_price;
            $user->save();

            $balance_history = new Balance_history;
            $balance_history->user_id = $check_key->id;
            $balance_history->action = "Cut Balance";
            $balance_history->quantity = $total_price;
            $balance_history->desc = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
            $balance_history->save();

            $activity = new Activity;
            $activity->user_id = $check_key->id;
            $activity->type = "Order";
            $activity->description = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
            $activity->user_agent = $r->header('User-Agent');
            $activity->ip = $r->ip();
            $activity->save();

            return response()->json(['success'=>true, 'data'=>['id'=>$order->id]]);
        }else if($action == 'status') {
            $order_id = $r->order_id;
            if(empty($order_id)) {
                return response()->json(['error'=>'Incorrect request']);
            }

            $check_order = Order::find($order_id);
            if(!$check_order) {
                return response()->json(['error','Order not found']);
            }

            $order_status = $check_order->status;
            return response()->json([
                'success'=>'true',
                'data'=> [
                    'status'=>$order_status,
                    'start_count'=>$check_order->start_count,
                    'remains'=>$check_order->remains,
                ]
            ]);
        }
    	
        
    }

    public function pulsa(Request $r) {

        $key = $r->key;
        $action = $r->action;
        $list_action = ['order','services','status'];



        if(empty($key) || empty($action)) {
           return response()->json(['error'=>'Incorrect Request']);
        }
     
        $check_key = User::where('api_key',$key)->first();
        

     
        if(!$check_key) {
            return response()->json(['error'=>'Your API Key is not valid']);
        }else if(!in_array($action, $list_action)) {
            return response()->json(['error'=>'Invalid Action']);
        }
        $user_balance = $check_key->balance;
        $user_status = $check_key->status;

        if($user_status == 'Not Active') {
            return response()->json(['error'=>'Akun tidak aktif']);
        }
        // API SERVICES
        if($action == 'services') {
            $services = Services_pulsa::all();
            $array = [];

            foreach($services as $service){
                $array['status'] = 'Success';
                $array['data'][] = array('id'=>$service->id,
                                         'name'=>$service->name,
                                         'oprator'=>$service->oprator->name,
                                         'category'=>$service->category->name,
                                        'price'=>$service->price + $service->keuntungan,
                                        'status'=>$service->status
                                    );
            }
            return response()->json($array);
        }else if($action == 'order') {
            $service = $r->service;
            $target = $r->target;

            if(empty($service) || empty($target) ) {
                return response()->json(['error'=>'Incorrect Request']);
            }

            $check_service = Services_pulsa::find($service);
            if(empty($check_service)) {
                return response()->json(['error'=>'Invalid Service ID']);
            }

            $service_price = $check_service->price + $check_service->keuntungan;
            $total_price = $check_service->price + $check_service->keuntungan;
            $service_status = $check_service->status;
            $service_name = $check_service->name;
            $service_pid = $check_service->code;
            $service_provider = $check_service->provider;
            $service_provider_name = $check_service->provider->name;


            if($service_status == 'Not Active') {
                return response()->json(['error'=>'Layanan tidak aktif']);
            }else if($user_balance < $service_price) {
                return response()->json(['error'=>'Saldo tidak cukup']);
            }


            $user = User::find($check_key->id);
            if($user->balance < $total_price) {
                Alert::error('Saldo tidak cukup','Error');
                session()->flash('danger','Error: Saldo anda tidak cukup (2) ');
                return redirect()->back();
            }

            $r->validate([ 
                        'service'=>'required',
                    ],
                    [
                        'service.required'=>'Harap pilih layanan terlebih dahulu!',
                    ]);
            $api_link = $check_service->provider->link;
            $api_key = $check_service->provider->api_key;

            if($check_service->provider->name == "PORTALPULSA") {
                // MASUKKAN API PORTALPULSA
                $key = $check_service->provider->api_key;
                $additional = $check_service->provider->additional;
                foreach(explode($additional,'|') as $data_additional) {
                    $user_id = $data_additional[0];
                    $secret = $data_additional[1];
                }

                if(isset($r->pln)){
                    $order = OrderPulsa::portalpulsa($user_id, $key, $secret, $service_pid, $target, $r->pln);
                }else{
                    $order = OrderPulsa::portalpulsa($user_id, $key, $secret, $service_pid, $target);
                }

                if($order['status'] == false) {
                    $order['status'] = false;
                    $order['message'] = "Layanan tidak tersedia";
                }else{
                    $oid = $order['order_id'];
                    $poid = $oid;
                }
            }else{
                $order['status'] = false;
                $order['message'] = "Layanan tidak tersedia";
            }
            
            
            if($order['status'] == false){
                return response()->json(['error'=>'Server maintenance']);
            }
            

            $poid = $order["order_id"];    
            $order = new Orders_pulsa;
            $order->oid = $poid;
            $order->poid = $poid;
            $order->user_id = $check_key->id;
            $order->service_id = $service;
            if(isset($r->pln)){
                $order->data = $target;
            }else{
                $order->data = $target." - ".$r->pln;
            }
            $order->sn = "";
            $order->price = $total_price;
            $order->status = 'Pending';
            $order->place_from = 'API';
            $order->refund = 0;
            $order->save();

            
            $user->balance = $user->balance - $total_price;
            $user->save();

            $balance_history = new Balance_history;
            $balance_history->user_id = $check_key->id;
            $balance_history->action = "Cut Balance";
            $balance_history->quantity = $total_price;
            $balance_history->desc = "Melakukan pemesanan $service_name sebesar Rp ".$total_price;
            $balance_history->save();

            $activity = new Activity;
            $activity->user_id = $check_key->id;
            $activity->type = "Order";
            $activity->description = "Melakukan pemesanan $service_name sebesar Rp ".$total_price;
            $activity->user_agent = $r->header('User-Agent');
            $activity->ip = $r->ip();
            $activity->save();

            return response()->json(['success'=>true, 'data'=>['id'=>$order->id]]);
        }else if($action == 'status') {
            $order_id = $r->order_id;
            if(empty($order_id)) {
                return response()->json(['error'=>'Incorrect request']);
            }

            $check_order = Orders_pulsa::find($order_id);
            if(!$check_order) {
                return response()->json(['error'=>'Order not found']);
            }

            $order_status = $check_order->status;
            $sn = $check_order->sn;
            return response()->json([
                'success'=>'true',
                'data'=> [
                    'status'=>$order_status,
                    'sn'=>$sn,
                ]
            ]);
        }
    }

    public function sosmed_doc() {
        if(Auth::check()) {
            $user = User::where('id',Auth::user()->id)->first();
           return view('api.sosmed_doc', compact('user'));
        }else{
    	   return view('api.sosmed_doc'); 
        }
    }

    public function pulsa_doc() {
    	return view('api.pulsa_doc');
    }
}
