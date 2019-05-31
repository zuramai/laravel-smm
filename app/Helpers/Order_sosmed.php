<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Service;
use App\Helpers\Oper\Bulkfollows as Bulkfollows;
use App\Helpers\Oper\PerfectSMM as PerfectSMM;
use App\Order;


class Order_sosmed {
	public static function irvankede($api_link,$key,$api_id, $pid, $target, $quantity, $custom_comments = false, $custom_link = false) {

		$api_postdata = [
			'api_id'=> $api_id, 
			'api_key'=>$key, 
			'service'=>$pid, 
			'target'=>$target, 
			'quantity'=>$quantity,
		];	

		if($custom_comments){
			$api_postdata['custom_comments'] = $custom_comments;
		}else if($custom_link) {
			$api_postdata['custom_link'] = $custom_link;
		}

		foreach($api_postdata as $key => $value) {
			$_postdata[] = $key.'='.urlencode($value);
		}
		// dd(join('&', $_postdata));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_link);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_postdata));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        $json_result = json_decode($chresult,true);
        // dd($json_result);

        if(isset($json_result['error'])) {
            return ['status' => false, 'message' => $json_result['error']];
        }else if($json_result['status'] == true) {
            return ['status' => $json_result['status'], 'order_id' => $json_result['data']['id']];
        }else if($json_result['status'] == false) {
        	return ['status' => $json_result['status'], 'message' => $json_result['data']];
        }
    }

    public static function jap($api_key,  $pid, $post_link, $post_quantity, $custom_comments = false, $custom_link = false) {
        $api_postdata = "key=$api_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://justanotherpanel.com/api/v2");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        // echo $chresult;
        curl_close($ch);
        $json_result = json_decode($chresult);
        if(isset($json_result->order)) {
            return ['status' => true, 'order_id' => $json_result->order];
        }else{
            return ['status' => false, 'message' => $json_result->error];
        }
    }

    public static function bulkfollows($pid, $post_link, $post_quantity, $custom_comment=false, $username = false) {
        
        $bulkfollows = new Bulkfollows;
        if($custom_comment != false) {
            $order = $bulkfollows->order(array('service' => $pid, 'link' => $post_link, 'comments' => $custom_comment)); # Custom Comments
        }else if($username != false) {
            $order = $bulkfollows->order(array('service' => $pid, 'link' => $post_link, 'quantity' => $post_quantity, 'username' => $username)); # Comment Likes
        }else{
            $order = $bulkfollows->order(array('service' => $pid, 'link' => $post_link, 'quantity' => $post_quantity)); 
        }

        if(isset($order->error)) {
            return ['status'=>false,'message'=>$order->error];
        }else{
            return ['status' => true, 'order_id' => $order->order];
        }
    }

    public static function perfectsmm($pid, $post_link, $post_quantity, $custom_comment=false, $username = false) {
        
        $perfectsmm = new PerfectSMM;
        if($custom_comment != false) {
            $order = $perfectsmm->order(array('service' => $pid, 'link' => $post_link, 'comments' => $custom_comment)); # Custom Comments
        }else if($username != false) {
            $order = $perfectsmm->order(array('service' => $pid, 'link' => $post_link, 'quantity' => $post_quantity, 'username' => $username)); # Comment Likes
        }else{
            $order = $perfectsmm->order(array('service' => $pid, 'link' => $post_link, 'quantity' => $post_quantity)); 
        }
        if(isset($order->error)) {
            return ['status'=>false,'message'=>$order->error];
        }else{
            return ['status' => true, 'order_id' => $order->order];
        }
    }

    public static function smmindo($pid, $post_link, $post_quantity){
        $provider = Provider::where('name','SMMINDO')->first();
        $api_key = $provider->api_key;
        $api_link = $provider->api_link;

        $api_postdata = "api_key=$api_key&action=order&service=$pid&data=$post_link&quantity=$post_quantity";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_link);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        // echo $chresult;
        curl_close($ch);
        $json_result = json_decode($chresult);

        if($json_result->status == false) {
            return ['status'=>false,'message'=> $json_result->data->msg];
        }else{
            return ['status' => true, 'order_id' => $json_result->data->id];
        }   
    }

    public static function vipmember($pid, $post_link, $post_quantity, $custom_comment = false) {
        $provider = Provider::where('name','VIPMEMBER')->first();
        $api_key = $provider->api_key;
        $api_link = $provider->api_link;

        if($custom_comment != false) {
            $api_postdata = "api_key=$api_key&action=order&service=$pid&data=$post_link&comments=$custom_comment";
        }else{
            $api_postdata = "api_key=$api_key&action=order&service=$pid&data=$post_link&quantity=$post_quantity";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_link);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        // echo $chresult;
        curl_close($ch);
        $json_result = json_decode($chresult);

        if($json_result->status == false) {
            return ['status'=>false,'message'=> $json_result->data->msg];
        }else{
            return ['status' => true, 'order_id' => $json_result->data->order_id];
        }   
    }

    public static function manual($pid, $post_link, $post_quantity, $custom_comments = false) {
        $latest = Order::orderBy('id','desc')->first();
        if(isset($order->error)) {
            return ['status'=>false,'message'=> "Layanan tidak tersedia"];
        }else{
            return ['status' => true, 'order_id' => $latest->id+1];
        }   
    }


}

 ?>