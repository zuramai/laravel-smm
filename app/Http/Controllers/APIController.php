<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Order;
use Auth;
use Log;
use App\User;
use App\Helpers\FArray;
use App\Helpers\SearchKey;
use App\Helpers\Order_pulsa as OrderPulsa;
use App\Helpers\Order_sosmed as OrderSosmed;
use App\Activity;
use App\Service_cat;
use App\Services_pulsa;
use App\Provider;
use App\Balance_history;
use App\Orders_pulsa;
use App\API;
use App\ApiRequestParam;
use App\ApiRequestHeader;
use App\ApiResponseLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;


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
        $user_id = $check_key->id;
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

            $data_service = Service::find($service);
            if(empty($data_service)) {
                return response()->json(['error'=>'Invalid Service ID']);
            }

            $service_price = $data_service->price_oper + $data_service->keuntungan;
            $service_id = $data_service->id;
            $service_min = $data_service->min;
            $service_max = $data_service->max;
            $service_type = $data_service->type;
            $service_status = $data_service->status;
            $service_pid = $data_service->pid;
            $service_provider = $data_service->provider;
            $service_provider_name = $data_service->provider->name;
            $api_id = $data_service->provider->api_id;


            if($post_quantity < $service_min) {
                return response()->json(['error'=>'Minimal jumlah adalah '.$service_min]);
            }else if($post_quantity > $service_max) {
                return response()->json(['error'=>'Maksimal jumlah adalah '.$service_max]);
            }else if($service_status == 'Not Active') {
                return response()->json(['error'=>'Layanan tidak aktif']);
            }

            $total_price =  ($data_service->price_oper + $data_service->keuntungan) / 1000 * $r->quantity ;

            $user = User::find($check_key->id);
            if($user->balance < $total_price) {
                return response()->json(['error'=>'Saldo tidak cukup']);
            }

            $custom_comment = false;
            $likes_comments = false;
            
            if (isset($r->custom_comment)) {
                $custom_comment = true;
                
            }else if(isset($r->username)) {
                $likes_comments = true;
            }

            
            if($data_service->type == 'Custom Comment') {
                if (isset($r->custom_comment)) {
                    $custom_comment = true;
                    $custom_comments = $r->custom_comment;
                }else{
                    return response()->json(['error'=>'Incorrect Request']);
                }
            }else if($data_service->type == 'Comment Likes') {
                if(isset($r->username)) {
                    $likes_comments = true;
                    $username = $r->username;
                }else{
                    return response()->json(['error'=>'Incorrect Request']);
                }
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
            $api = API::find($data_service->provider->api_id);

            // Build api request parameters
            $params = [];
            $apiRequestParams = ApiRequestParam::where(['api_id' => $api_id, 'api_type' => 'order'])->get();
            if (!$apiRequestParams->isEmpty()) {
                foreach ($apiRequestParams as $row) {
                    if ($row->param_type === 'custom') {
                        $params[$row->param_key] = $row->param_value;
                    } else {
                        // If column is package id then assign package id value in api mapping
                        if ($row->param_value == 'custom_comments' && $data_service->type == 'Custom Comment') {
                                $params[$row->param_key] = $r->custom_comment;
                        } elseif ($row->param_value == 'username' && $data_service->type == 'Comment Likes') {
                         
                            $params[$row->param_key] = $r->username; 
                        } elseif ($row->param_value == 'service_id') {
                            $params[$row->param_key] = $data_service->pid; 
                        } elseif ($row->param_value == 'target') {
                            $params[$row->param_key] = $post_link; 
                        } elseif ($row->param_value == 'quantity') {
                            $params[$row->param_key] = $post_quantity; 
                        }
                    }
                }
                // create new client and make call
                $client = new Client();
                try {
                    // if Method is GET then change request key in Guzzle
                    $param_key = 'form_params';
                    if ($api->order_method === 'GET') {
                        $param_key = 'query';
                    }

                    $res = $client->request($api->order_method, $api->order_end_point, [
                        $param_key => $params,
                        'headers' => ['Accept' => 'application/json'],
                    ]);

                    if ($res->getStatusCode() === 200) {
                        $resp = $res->getBody()->getContents();
                        $json_result = json_decode($resp, true);
                        $poid = SearchKey::arraySearch($json_result, $api->order_id_key);


                        // Response keys are equal to success response?
                        if ($poid) {
                            // Get orderID column from API response
                            $json_result = json_decode($resp);

                            $order = new Order;
                            $order->poid = $poid;
                            $order->user_id = $check_key->id;
                            $order->service_id = $service_id;
                            $order->target = $post_link;
                            $order->quantity = $post_quantity;
                            $order->start_count = 0;
                            $order->remains = $post_quantity;
                            $order->price = $total_price;
                            $order->status = 'Pending';
                            $order->place_from = 'API';
                            if($custom_comment) {
                                $order->notes = $custom_comments;
                            }else if($likes_comments) {
                                $order->notes = $username;
                            }else{
                                $order->notes = "-";
                            }
                            $order->refund = 0;
                            $order->save();

                            $user->balance = $user->balance - $total_price;
                            $user->save();

                            $balance_history = new Balance_history;
                            $balance_history->user_id = $check_key->id;
                            $balance_history->action = "Cut Balance";
                            $balance_history->quantity = $total_price;
                            $balance_history->desc = "Melakukan Pemesanan $data_service->name Dengan Jumlah $post_quantity";
                            $balance_history->save();

                            $activity = new Activity;
                            $activity->user_id = $check_key->id;
                            $activity->type = "Order";
                            $activity->description = "Melakukan Pemesanan $data_service->name Dengan Jumlah $post_quantity";
                            $activity->user_agent = $r->header('User-Agent');
                            $activity->ip = $r->ip();
                            $activity->save();

                            ApiResponseLog::create([
                                'order_id' => $order->id,
                                'api_id' => $api_id,
                                'response' => $resp
                            ]);

                        }else{
                            Log::error($resp);
                            Log::error($params);
                            return response()->json(['success'=>false,'data' => "Layanan tidak tersedia"]);
                        }
                        
                        return response()->json(['success'=>true, 'data'=>['id'=>$order->id]]);
                    }

                } catch
                (ClientException $e) {

                        return response()->json(['success'=>false, 'data'=>"Layanan tidak tersedia."]);

                }
            }

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
            $provider_name = $check_service->provider->name;
            $api_id = $check_service->provider->api_id;


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

            $api = API::findOrFail($api_id);
            $ApiRequestHeader = ApiRequestHeader::where('api_id', $api_id)->where('api_type','order')->pluck('header_value','header_key');
            $ApiRequestParam = ApiRequestParam::where('api_id', $api_id)->where('api_type','order')->pluck('param_value','param_key');
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
                    $data[$key] = $service_pid;
                }else if($value == "phone"){
                    $data[$key] = $target;
                }else if($value == "portalpulsa_trxid"){
                    $poid = rand(100000,10000000);
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
            // dd($data);

            # INITIAL PARAMETER
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            $json_result = json_decode($result);
            
            $success_response = FArray::array_cast_recursive(json_decode($api->order_success_response,true));

            // Response keys are equal to success response?
            if (empty(FArray::array_diff_key_recursive(FArray::array_cast_recursive(json_decode($result)), $success_response))) {
                // Get orderID column from API response

                $order = new Orders_pulsa;
                $order->oid = $poid;
                $order->poid = $poid;
                $order->user_id = $check_key->id;
                $order->service_id = $check_service->id;
                $order->price = $total_price;
                $order->data = $target;
                $order->sn = "";
                $order->status = 'Pending';
                $order->place_from = 'API';
                $order->refund = 0;
                $order->save();

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

                $user = User::find($check_key->id);
                $user->balance = $user->balance - $total_price;
                $user->save();

                $balance_history = new Balance_history;
                $balance_history->user_id = $check_key->id;
                $balance_history->action = "Cut Balance";
                $balance_history->quantity = $total_price;
                $balance_history->desc = "Melakukan Pemesanan $service_name ".config('web_config')['CURRENCY_CODE']." $total_price (Order ID: $poid)";
                $balance_history->save();

                $activity = new Activity;
                $activity->user_id = $check_key->id;
                $activity->type = "Order";
                $activity->description = "Melakukan Pemesanan $service_name ".config('web_config')['CURRENCY_CODE']." $total_price (Order ID: $poid)";
                $activity->user_agent = $r->header('User-Agent');
                $activity->ip = $r->ip();
                $activity->save();

                ApiResponseLog::create([
                    'order_id' => $order->id,
                    'api_id' => $api_id,
                    'response' => $result
                ]);

                return response()->json(['success'=>true, 'data'=>['id'=>$order->id]]);
            }else{
                $error = FArray::array_diff_key_recursive(FArray::array_cast_recursive(json_decode($resp)), $success_response);
                return response()->json(['success'=>false, 'data'=>"Layanan tidak tersedia"]);
            }

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

    public function incorrect_request() {
        return response()->json(['error'=>'Incorrect Request']);
    }

    public function profile(Request $r) {
        $key = $r->key;



        if(empty($key)) {
           return response()->json(['error'=>'Incorrect Request']);
        }
        $user = User::where('api_key',$key)->first();
     
        if(!$user) {
            return response()->json(['error'=>'Your API Key is not valid']);
        }
        $user_balance = $user->balance;
        $user_status = $user->status;

        return response()->json([
            'success'=>true,
            'data'=> [
                'account_status' => $user_status,
                'balance' => $user_balance
            ]
        ]);
    }

    public function profile_doc() {
        return view('api.profile_doc');
    }

}
