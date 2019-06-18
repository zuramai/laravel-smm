<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Services_pulsa;
use App\Orders_pulsa;
use Carbon\Carbon;

class Order_pulsa {
	public static function portalpulsa($user_id, $key, $secret, $service, $target, $pln = NULL) {
        $url = 'https://portalpulsa.com/api/connect/';
        $oid = rand(0,99999);
        $no = 1;

        $check = Orders_pulsa::where('data',$target)->where('created_at',Carbon::today())->first();
        if($check) {
            $no += 1;
        }   

        $header = array(
        'portal-userid: '.$user_id,
        'portal-key: '.$key, // lihat hasil autogenerate di member area
        'portal-secret: '.$secret, // lihat hasil autogenerate di member area
        );
            
        $data = array(
            'inquiry' => 'I', // konstan
            'code' => $service, // kode produk
            'phone' => $target, // nohp pembeli
            'trxid_api' => $oid, // Trxid / Reffid dari sisi client
            'no' => $no, // untuk isi lebih dari 1x dlm sehari, isi urutan 1,2,3,4,dst
        );
        
        if($pln) {
            $data = array(
            'inquiry' => 'PLN', // konstan
            'code' => $service, // kode produk
            'phone' => $target, // nohp pembeli
            'idcust' => $pln, // nomor meter atau id pln
            'trxid_api' => $oid, // Trxid / Reffid dari sisi client
            'no' => $no, // untuk isi lebih dari 1x dlm sehari, isi urutan 2,3,4,dst
            );
        }
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $json_result = json_decode($result,true);
        $result = $json_result['result'];
        $message = $json_result['message'];

        if ( $result == "failed") {
            $msg_type = "error";
            return array('status'=>false, 'message'=>$message);
        }else{
            return array('status'=>true, 'order_id'=>$oid);
        }
    }

	public static function oceanh2h($service,$target) {
        $provider = Provider::where('name','OCEANH2H')->first();
        $api_key =  $provider->api_key;
        $link =  $provider->link;

        $api_postdata = array(
            'api_key' => $api_key,
            'service' => $service,
            'data' => $target
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        $json_result = json_decode($chresult,true);
        if(isset($json_result['error'])){
            $error =  $json_result['error'];
            return array('status'=>false, 'message'=>$error);
        }else{
            $poid = $json_result["data"]['id'];
            $oid = $poid;

            return array('status'=>true, 'order_id'=>$oid);
        }
	}

    public static function atlantic() {

    }

    public static function dpedia($api_link, $api_key, $service, $phone) {
        $api_postdata = "api_key=$api_key&service=$pid&phone=$phone";
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

        if(isset($json_result['error'])){
            $error =  $json_result['error'];
            return array('status'=>false, 'message'=>$error);
        }else{
            $poid = $json_result->code_trx;
            $oid = $poid;
            return array('status'=>true, 'order_id'=>$oid);
        }
    }
}


 ?>