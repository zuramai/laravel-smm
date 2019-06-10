<?php

namespace PTTridi\Cekmutasi;

class Cekmutasi
{
    // place your API Key here
    private $apiKey = "";

    private $apiUrl = "https://api.cekmutasi.co.id/v1";

    private $service;

    const BANK = 1;
    const PAYPAL = 2;

    public function __construct()
    {
        
    }

    public function bank()
    {
        $this->service = self::BANK;
        return $this;
    }

    public function paypal()
    {
        $this->service = self::PAYPAL;
        return $this;
    }

    private function request($endpoint, $params = [])
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_FRESH_CONNECT   => true,
            CURLOPT_URL             => $this->apiUrl . $endpoint,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => http_build_query($params),
            CURLOPT_HEADER          => false,
            CURLOPT_HTTPHEADER      => ['API-KEY: ' . $this->apiKey, 'Accept: application/json'],
            CURLOPT_SSL_VERIFYHOST  => 0,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_CONNECTTIMEOUT  => 10,
            CURLOPT_TIMEOUT         => 120,
            CURLOPT_FAILONERROR     => true,
            CURLOPT_IPRESOLVE       => CURL_IPRESOLVE_V4
        ]);

        $result = curl_exec($ch);
        $errno = curl_errno($ch);

        if( $errno )
        {
            return $this->printOut([
                'success'           => false,
                'error_message'     => curl_error($ch),
                'response'          => [] 
            ]);
        }

        return $result;
    }

    private function printOut($array)
    {
        return json_encode($array);
    }

    public function mutation($searchOptions = [])
    {
        $search = [
            'search'    => $searchOptions
        ];

        if( $this->service == self::BANK ) {
            $endpoint = "/bank/search";
        }
        elseif( $this->service == self::PAYPAL ) {
            $endpoint = "/paypal/search";
        }
        else {
            return $this->printOut([
                'success'       => false,
                'error_message' => 'Undefined service',
                'response'      => []
            ]);
        }

        return $this->request($endpoint, $search);
    }
}
