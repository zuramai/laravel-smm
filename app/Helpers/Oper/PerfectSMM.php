<?php 
namespace App\Helpers\Oper;
use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Service;


class PerfectSMM {
	const API_URL = 'https://perfectsmm.com/api/v2'; // API URL

    public static function getApiKey() {
    	$provider = Provider::where('name','PERFECTSMM')->first();
    	return $provider->api_key;
    } 

    public static function order($data) { // add order
        $post = array_merge(array('key' => self::getApiKey(), 'action' => 'add'), $data);
        return json_decode(self::connect($post));
    }

    public static function status($order_id) { // get order status
        return json_decode(self::connect(array(
            'key' => self::getApiKey(),
            'action' => 'status',
            'order' => $order_id
        )));
    }

    public static function multiStatus($order_ids) { // get order status
        return json_decode(self::connect(array(
            'key' => self::getApiKey(),
            'action' => 'status',
            'orders' => implode(",", (array)$order_ids)
        )));
    }

    public static function services() { // get services
        return json_decode(self::connect(array(
            'key' => self::getApiKey(),
            'action' => 'services',
        )));
    }

    public static function balance() { // get balance
        return json_decode(self::connect(array(
            'key' => self::getApiKey(),
            'action' => 'balance',
        )));
    }


    public static function connect($post) {
        $_post = Array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name.'='.urlencode($value);
            }
        }

        $ch = curl_init(self::API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        return $result;
    }
}


?>