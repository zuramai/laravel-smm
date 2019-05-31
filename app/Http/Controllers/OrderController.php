<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service_cat;
use App\Custom_price;
use App\Service;
use Validator;
use App\Services_pulsa;
use App\Provider;
use App\Order;
use App\Orders_pulsa;
use App\Oprator;
use App\Helpers\Order_pulsa as OrderPulsa;
use App\Helpers\Order_sosmed as OrderSosmed;
use App\Activity;
use App\Balance_history;
use Auth;
use Alert;
use App\User;

class OrderController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }

    public function sosmed(){
        $cat = Service_cat::where('type','SOSMED')->where('status','Active')->orderBy('name','ASC')->get();
        return view('order.sosmed.new', compact('cat'));
    }
    public function sosmed_mass() {
        return view('order.sosmed.mass');
    }
    public function sosmed_history(Request $r){
        $search = $r->get('search');
        $order = Order::where('user_id',auth()->user()->id)->where(function($q) use ($r, $search) {
             $q->where('target','LIKE',"%$search%")
            ->orWhere('id','LIKE',"%$search%");
        })->orderBy('id','desc')->paginate(15);
                                                            
        return view('order.sosmed.history', compact('order'));
    }
    public function sosmed_post(Request $r) {

        if($r->service == NULL) {
            session()->flash('danger','Harap pilih layanan terlebih dahulu!');
            return redirect()->back();
        }

        $service_id = $r->service;
        $post_quantity = $r->quantity;
        $post_link = $r->target;

        $custom_comment = false;
        $likes_comment = false;
        
        if (isset($r->custom_comment)) {
            $custom_comment = true;
            
        }else if(isset($r->likes_comment)) {
            $likes_comment = true;
        }

        $api_id = env('API_ID_IRV');
        $data_service = Service::where('id',$service_id)->first();  
        $pid = $data_service->pid;
        $min = $data_service->min;
        $max = $data_service->max;

        $custom_price = Custom_price::where('service_id',$data_service->id)->where('user_id',Auth::user()->id)->first();
        
        if(!$custom_price) {
            $total_price = ($data_service->price + $data_service->keuntungan) / 1000 * $r->quantity ;
        }else{
            $total_price = ($data_service->price + $data_service->keuntungan - $custom_price->potongan) / 1000 * $r->quantity;
        }

        $user = User::find(Auth::user()->id);
        if($user->balance < $total_price) {
            Alert::error('Saldo tidak cukup','Error');
            session()->flash('danger','Error: Saldo anda tidak cukup (2) ');
            return redirect()->back();
        }

        
        if($data_service->type == 'custom_comment') {
            $custom_comments = $r->custom_comment;
        }else if($data_service->type == 'comment_likes') {
            $post_links = $r->comment_likes;
        }
        $r->validate([ 
                    'service'=>'required',
                    'quantity'=>"required|integer|min:$min|max:$max"
                ],
                [
                    'service.required'=>'Harap pilih layanan terlebih dahulu!',
                    'quantity.required'=>'Harap isi jumlah terlebih dahulu!',
                    'min'=>'Jumlah minimal adalah $min',
                    'max'=>'Jumlah maksimal adalah $max',
                ]);
        $api_link = $data_service->provider->link;
        $api_key = $data_service->provider->api_key;

        if($data_service->provider->name == 'IRV'){
            if(isset($r->custom_comment)) {
                $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $pid, $post_link, $post_quantity, $custom_comments);
            }else if(isset($r->custom_link)) {
                $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $pid, $post_link, $post_quantity, false, $post_links);
            }else{
                $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $pid, $post_link, $post_quantity);
            }
        }else if($data_service->provider->name == 'JAP') {
            if(isset($r->custom_comment)) {
                $order = OrderSosmed::jap($api_key, $pid, $post_link, $post_quantity, $custom_comments);
            }else if(isset($r->custom_link)) {
                $order = OrderSosmed::jap($api_key, $pid, $post_link, $post_quantity, false, $post_links);
            }else{
                $order = OrderSosmed::jap($api_key, $pid, $post_link, $post_quantity);
            }
        }else if($data_service->provider->name == 'BULKFOLLOWS') {
            if(isset($r->custom_comment)) {
                $order = OrderSosmed::bulkfollows($pid, $post_link, $post_quantity, $custom_comments);
            }else if(isset($r->custom_link)) {
                $order = OrderSosmed::bulkfollows($pid, $post_link, $post_quantity, false, $post_links);
            }else{
                $order = OrderSosmed::bulkfollows($pid, $post_link, $post_quantity);
            }
        }else if($data_service->provider->name == 'PERFECTSMM') {
            if(isset($r->custom_comment)) {
                $order = OrderSosmed::perfectsmm($pid, $post_link, $post_quantity, $custom_comments);
            }else if(isset($r->custom_link)) {
                $order = OrderSosmed::perfectsmm($pid, $post_link, $post_quantity, false, $post_links);
            }else{
                $order = OrderSosmed::perfectsmm($pid, $post_link, $post_quantity);
            }
        }else if($data_service->provider->name == 'MANUAL') {
            if(isset($r->custom_comment)) {
                $order = OrderSosmed::manual($pid, $post_link, $post_quantity, $custom_comments);
            }else if(isset($r->custom_link)) {
                $order = OrderSosmed::manual($pid, $post_link, $post_quantity, false, $post_links);
            }else{
                $order = OrderSosmed::manual($pid, $post_link, $post_quantity);
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
            Alert::error('Server maintenance','Error');
            session()->flash('danger','Error: '.$order['message']);
            return redirect()->back();
        }
        

        $poid = $order["order_id"];    
        $order = new Order;
        $order->poid = $poid;
        $order->user_id = Auth::user()->id;
        $order->service_id = $service_id;
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
        $balance_history->user_id = Auth::user()->id;
        $balance_history->action = "Cut Balance";
        $balance_history->quantity = $total_price;
        $balance_history->desc = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
        $balance_history->save();

        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->type = "Order";
        $activity->description = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
        $activity->user_agent = $r->header('User-Agent');
        $activity->ip = $r->ip();
        $activity->save();

        Alert::success('Sukses order!','Sukses');
        session()->flash('success',"Pesanan anda akan segera diproses.<br><b>ID Pesanan: </b>$order->id<br><b>Layanan:</b> $data_service->name <br> <b>Target:</b> $post_link <br> <b>Jumlah:</b> $post_quantity <br> <b>Harga:</b> Rp ".number_format($total_price));
        return redirect()->back();
    }
    public function get_service(Request $r){
        $service = Service::where('category_id',$r->cat_id)->where('status','Active')->orderBy('name','asc')->get();
        $return = "<option value=''>Pilih salah satu..</option>";
        foreach($service as $data){
            $return .= "<option value='$data->id'>$data->name</option>";
        }
        return $return;
    }
    public function check_sosmed(Request $r) {
        
        $sid = $r->sid;
        $check = Service::find($sid);

        if($check->type == 'Custom Comment') {
            return "custom_comment";
        }else if($check->type == 'Comment Likes') {
            return "likes_comment";
        }else{
            return $check->type;
        }
    }
    public function get_service_data(Request $r){
        $service = Service::where('id',$r->sid)->first();
        $custom_price = Custom_price::where('service_id',$service->id)->where('user_id',Auth::user()->id)->first();

        if(!$custom_price) {
            $price = $service->price + $service->keuntungan;
        }else{
            $price = ($service->price + $service->keuntungan) - $custom_price->potongan;
        }
        $note = $service->note;
        
        return "<div class='alert alert-primary alert-has-icon'>
                              
                              <div class='alert-body'>

                                <div class ='alert-title'><span class='alert-icon'><i class='fas fa-info-circle'></i></span> <b>Informasi Layanan</b></div>
                                <b>Harga/1000</b> : Rp $price<br>
                                <b>Min order</b> : $service->min<br>
                                <b>Max order</b> : $service->max<br>
                                <b>Note</b> : $note
                              </div>
                            </div>";
    }

    public function get_price(Request $r){
        $service = Service::where('id',$r->sid)->first();
        $custom_price = Custom_price::where('service_id',$service->id)->where('user_id',Auth::user()->id)->first();

        if(!$custom_price) {
            $price = $service->price + $service->keuntungan;
        }else{
            $price = ($service->price + $service->keuntungan) - $custom_price->potongan;
        }
        echo $price;
    }


    public function sosmed_mass_post(Request $r) {
        $r->validate([
            'mass'=>'required'
        ]);
        $mass = $r->mass;
        $textAr = explode(PHP_EOL, $mass);
        $total_error = 0;
        $total_success = 0;
        $final_price = 0;

        // dd($textAr);
        foreach ($textAr as $line) {
            $separateLine = explode("|",$line); 

            if (count($separateLine) != 3) {
                // session()->flash('danger','Input tidak sesuai');
                return redirect()->back()->withErrors('Input tidak sesuai');
            }

            $post_service = $separateLine[0];
            $post_link = $separateLine[1];
            $post_quantity = $separateLine[2];

            $post_array = [
                'sid'=>$post_service,
                'post_link' => $post_link,
                'post_quantity'=>$post_quantity
            ];
            
            $api_id = env('API_ID_IRV');
            $data_service = Service::where('id',$post_service)->first();  
            if(!$data_service) {
                $total_error++;
            }else{
                $pid = $data_service->pid;
                $min = $data_service->min;
                $max = $data_service->max;
                $validator = Validator::make($post_array, [ 
                    'sid'=>'exists:services,id',
                    'post_quantity'=>"integer|min:$min|max:$max"
                ]);
                if($validator->fails()){
                    $total_error += count($validator->messages());
                    continue;
                }
                $custom_price = Custom_price::where('service_id',$data_service->id)->where('user_id',Auth::user()->id)->first();
                if(!$custom_price) {
                    $total_price = ($data_service->price + $data_service->keuntungan) / 1000 * $post_quantity ;
                }else{
                    $total_price = ($data_service->price + $data_service->keuntungan - $custom_price->potongan) / 1000 * $post_quantity;
                }
                $user = User::find(Auth::user()->id);
                if($user->balance < $total_price) {
                    Alert::error('Saldo tidak cukup','Error');
                    session()->flash('danger','Error: Saldo anda tidak cukup (2) ');
                    return redirect()->back();
                }

               
                $api_link = $data_service->provider->link;
                $api_key = $data_service->provider->api_key;

                if($data_service->provider->name == 'IRV'){
                    $order = OrderSosmed::irvankede($api_link, $api_key, $api_id, $pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'JAP') {
                    $order = OrderSosmed::jap($api_key, $pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'BULKFOLLOWS') {
                    $order = OrderSosmed::bulkfollows($pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'PERFECTSMM') {
                    $order = OrderSosmed::perfectsmm($pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'MANUAL') {
                    $order = OrderSosmed::manual($pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'VIPMEMBER') {
                    $order = OrderSosmed::vipmember($pid, $post_link, $post_quantity);
                }else if($data_service->provider->name == 'SMMINDO') {
                    $order = OrderSosmed::smmindo($pid, $post_link, $post_quantity);
                }else{
                    $order['status'] = false;
                    $order['message'] = "Layanan tidak tersedia";
                }    

                if($order['status'] == true) {
                    $total_success++;
                    $final_price += $total_price;

                    $poid = $order["order_id"];    
                    $order = new Order;
                    $order->poid = $poid;
                    $order->user_id = Auth::user()->id;
                    $order->service_id = $post_service;
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
                    $balance_history->user_id = Auth::user()->id;
                    $balance_history->action = "Cut Balance";
                    $balance_history->quantity = $total_price;
                    $balance_history->desc = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
                    $balance_history->save();

                    $activity = new Activity;
                    $activity->user_id = Auth::user()->id;
                    $activity->type = "Order";
                    $activity->description = "Melakukan pemesanan sosial media sebesar Rp ".$total_price;
                    $activity->user_agent = $r->header('User-Agent');
                    $activity->ip = $r->ip();
                    $activity->save();
                }else{
                    $total_error++;
                }


            }

            
        } 
        session()->flash('success',"Pesanan anda telah diterima <br>Total sukses order: $total_success <br> Total gagal order: $total_error <br> Total harga: Rp ".number_format($final_price));
        return redirect()->back();
    }

    public function pulsa(){
        $cat = Service_cat::where('type','PULSA')->where('status','Active')->get();
        return view('order.pulsa.new', compact('cat'));
    }
    public function pulsa_order(Request $r){
        $r->validate([
            'service' => 'required|exists:services_pulsas,id',
            'target' => 'required',
        ]);

        $service = $r->service;
        $target = $r->target;

        $service_pulsa = Services_pulsa::find($service);
        $code = $service_pulsa->code;
        $name = $service_pulsa->name;
        $price = $service_pulsa->price + $service_pulsa->keuntungan;
        $provider_name = $service_pulsa->provider->name;

        $provider_link = $service_pulsa->provider->link;
        $provider_key = $service_pulsa->provider->key;

        if(Auth::user()->balance < $price) {
            Alert::error('Saldo tidak cukup','Gagal');
            session()->flash('danger','Gagal: Saldo tidak cukup');
            return redirect()->back();
        }

        if($provider_name == "PORTALPULSA") {
            // MASUKKAN API PORTALPULSA
            $user_id = env('PORTALPULSA_USER_ID');
            $key = env('PORTALPULSA_KEY');
            $secret = env('PORTALPULSA_SECRET');

            if(isset($r->pln)){
                $order = OrderPulsa::portalpulsa($user_id, $key, $secret, $code, $target, $r->pln);
            }else{
                $order = OrderPulsa::portalpulsa($user_id, $key, $secret, $code, $target);
            }

            if($order['status'] == false) {
                Alert::error('Server maintenance','Gagal');
                session()->flash('danger','Gagal');
                return redirect()->back();
            }else{
                $oid = $order['order_id'];
                $poid = $oid;
            }
        }else if($provider_name == "OCEANH2H") {
            $order = OrderPulsa::oceanh2h($code, $target);

            if($order['status'] == false) {
                $message = $order['message'];
                Alert::error('Server maintenance','Gagal');
                session()->flash('danger','Gagal: '.$message);
                return redirect()->back();
            }else{
                $oid = $order['order_id'];
                $poid = $oid;
            }
        }else{
            Alert::error('Hubungi admin','Failed');
            session()->flash('danger','Provider salah, silahkan kontak admin');
            return redirect()->back();
        }

        $insert = new Orders_pulsa;
        $insert->oid = $oid;
        $insert->poid = $poid;
        $insert->user_id = Auth::user()->id;
        $insert->service_id = $service_pulsa->id;
        $insert->price = $price;
        $insert->data = $target;
        $insert->sn = "";
        $insert->status = 'Pending';
        $insert->place_from = 'WEB';
        $insert->refund = 0;
        $insert->save();

        $user = User::find(Auth::user()->id);
        $user->balance = $user->balance - $price;
        $user->save();

        $balance_history = new Balance_history;
        $balance_history->user_id = Auth::user()->id;
        $balance_history->action = "Cut Balance";
        $balance_history->quantity = $price;
        $balance_history->desc = "Melakukan pemesanan $name seharga $price";
        $balance_history->save();

        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->type = "Order";
        $activity->description = "Melakukan pemesanan $name seharga $price";
        $activity->user_agent = $r->header('User-Agent');
        $activity->ip = $r->ip();
        $activity->save();

        Alert::success('Sukses melakukan pemesanan!','Sukses');
        session()->flash('success','<b>Pesanan telah diterima!</b> <br> <b>Layanan</b>: '.$name.' <br> <b>Harga:</b> Rp '.number_format($price).'<br><b>Tujuan:</b> '.$target);
        return redirect()->back();
        
    }
    public function pulsa_history(Request $r){
        $search = $r->get('search');
        $order = Orders_pulsa::where('user_id',auth()->user()->id)->where(function($q) use ($r, $search) {
             $q->where('data','LIKE',"%$search%")
            ->orWhere('id','LIKE',"%$search%");
        })->orderBy('id','desc')->simplePaginate(10);
        return view('order.pulsa.history', compact('order'));
    }
    public function get_service_pulsa(Request $r){
        $id = $r->id;

        $operators = Oprator::where('category_id',$id)->get();
        $hasil = "<option value=''>Pilih salah satu..</option>";
        foreach($operators as $operator) {
            $id = $operator->id;
            $name = $operator->name;
            $hasil .= "<option value='$id'>$name</option>";
        }
        return $hasil;
    }
    public function get_type_pulsa(Request $r){
        $id = $r->id;

        $services = Services_pulsa::where('oprator_id',$id)->get();

        if(empty($services)) {
            return "<option>Layanan belum tersedia</option>";
        }
        $hasil = "<option value=''>Pilih salah satu..</option>";
        foreach($services as $service) {
            $id = $service->id;
            $name = $service->name;

            $hasil .= "<option value='$id'>$name</option>";
        }
        return $hasil;
    }

    public function get_price_pulsa(Request $r) {
        $id = $r->id;
        $service = Services_pulsa::find($id);
        return $service->price;

    }

    public function tos() {
        return view('order.sosmed.tos');
    }

}
