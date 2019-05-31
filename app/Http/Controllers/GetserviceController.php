<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services_pulsa;
use App\Helpers\Oper\Bulkfollows as Bulkfollows;
use App\Service;
use App\Service_cat;
use App\Oprator;
use App\Provider;

class GetserviceController extends Controller
{
    public function portalpulsa() {
		$url = 'https://portalpulsa.com/api/connect/';

		$header = array(
                'portal-userid: P19231',
                'portal-key: dea373107d9cbaa88e10d67ac6dba65a', // lihat hasil autogenerate di member area
                'portal-secret: b33feb6506c672544a395f7289a88f107c1c5599d482ffbb8b6367b7f2b51cee', // lihat hasil autogenerate di member area
                );

		$data = array(
		'inquiry' => 'HARGA', // konstan
		'code' => 'pulsa', // pilihan: pln, pulsa, game
		);

		$untung = 200;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		$json_result = json_decode($result,true);
		// echo $json_result['message']['code'];
		// print_r($json_result);
		// dd($json_result);
		for($i = 0; $i < count($json_result['message']); $i++)
		{
		    $code =  $json_result['message'][$i]['code'];
		    $desc =  $json_result['message'][$i]['description'];
		    $price =  $json_result['message'][$i]['price'];
		    $newprice = $price + $untung;
		    $status =  $json_result['message'][$i]['status'];
		    $provider = $json_result['message'][$i]['provider'];
		    $oprator = $json_result['message'][$i]['operator'];

		    if($status == "normal")
		    {
		        $newstat = "Active";
		    }
		    else
		    {
		        $newstat = "Not Active";
		    }
		    

		    $check_provider = Provider::where('name','PORTALPULSA')->first();

		    if(!$check_provider) {
		    	dd('provider dengan nama PORTALPULSA tidak ada');
		    }

		    $operator = Oprator::where('name', $oprator)->first();
    
	    	$insert = Services_pulsa::updateOrCreate(
	    	 	['code' => $code],
	    	 	[
	    		'name' => $desc,
	    	 	'oprator_id' => $operator->id,
	    	 	'category_id' => $operator->category_id,
	    	 	'price' => $price,
	    	 	'status' => $newstat,
	    	 	'provider_id' => $check_provider->id,
	    	 ]
	    	);
	         echo "Success add services ! <br> Code : $code <br> Nama : $desc <br> Price : $price <br> Status : $status<br> ==============================<br><br>";    
	    
		}
    }

    public function portalpulsa_pln() {
		$url = 'https://portalpulsa.com/api/connect/';

		$header = array(
                'portal-userid: P104111',
                'portal-key: 5a8eba217f1f965fdecf34e7c8776845', // lihat hasil autogenerate di member area
                'portal-secret: d9e0f67df23f7a38b9c460860adf4e4542592b218bd1a3caa4d872aca8f6a72e', // lihat hasil autogenerate di member area
                );

		$data = array(
		'inquiry' => 'HARGA', // konstan
		'code' => 'PLN', // pilihan: pln, pulsa, game
		);

		$untung = 200;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		$json_result = json_decode($result,true);
		// echo $json_result['message']['code'];
		// print_r($json_result);
// 		dd($json_result);
		for($i = 0; $i < count($json_result['message']); $i++)
		{
		    $code =  $json_result['message'][$i]['code'];
		    $desc =  $json_result['message'][$i]['description'];
		    $price =  $json_result['message'][$i]['price'];
		    $newprice = $price + $untung;
		    $status =  $json_result['message'][$i]['status'];
		    $provider = $json_result['message'][$i]['provider'];
		    $oprator = $json_result['message'][$i]['operator'];

		    if($status == "normal")
		    {
		        $newstat = "Active";
		    }
		    else
		    {
		        $newstat = "Not Active";
		    }
		    

		    $check_provider = Provider::where('name','PORTALPULSA')->first();

		    if(!$check_provider) {
		    	dd('provider dengan nama PORTALPULSA tidak ada');
		    }

		    $operator = Oprator::where('name', $oprator)->first();
    
	    	$insert = Services_pulsa::updateOrCreate(
	    	 	['code' => $code],
	    	 	[
	    		'name' => $desc,
	    	 	'oprator_id' => $operator->id,
	    	 	'category_id' => $operator->category_id,
	    	 	'price' => $price,
	    	 	'status' => $newstat,
	    	 	'provider_id' => $check_provider->id,
	    	 ]
	    	);
	         echo "Success add services ! <br> Code : $code <br> Nama : $desc <br> Price : $price <br> Status : $status<br> ==============================<br><br>";    
	    
		}
    }

    public function portalpulsa_cat() {
    	$url = 'https://portalpulsa.com/api/connect/';

		$header = array(
                'portal-userid: P19231',
                'portal-key: dea373107d9cbaa88e10d67ac6dba65a', // lihat hasil autogenerate di member area
                'portal-secret: b33feb6506c672544a395f7289a88f107c1c5599d482ffbb8b6367b7f2b51cee', // lihat hasil autogenerate di member area
                );

		$data = array(
		'inquiry' => 'HARGA', // konstan
		'code' => 'pulsa', // pilihan: pln, pulsa, game
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		$json_result = json_decode($result,true);
		// echo $json_result['message']['code'];
		// print_r($json_result);
		// dd($json_result);
		for($i = 0; $i < count($json_result['message']); $i++)
		{
		    $code =  $json_result['message'][$i]['code'];
		    $desc =  $json_result['message'][$i]['description'];
		    $price =  $json_result['message'][$i]['price'];
		    $newprice = $price + 500;
		    $status =  $json_result['message'][$i]['status'];
		    $provider = $json_result['message'][$i]['provider'];
		    $oprator = $json_result['message'][$i]['operator'];

		    if($status == "normal")
		    {
		        $newstat = "Active";
		    }
		    else
		    {
		        $newstat = "Not Active";
		    }


		    $check_provider = Provider::where('name','PORTALPULSA')->first();

		    if(!$check_provider) {
		    	dd('provider dengan nama PORTALPULSA tidak ada');
		    }
	    
		    // INSERT CATEGORY

	    	$insert_cat = Service_cat::updateOrCreate(
	    		['name' => $provider],
	    		['type' => 'PULSA' , 'status' => 'Active']
	    	);	
	    	$id_category = $insert_cat->id;


	    	$insert_oprator = Oprator::updateOrCreate(
	    		['name' => $oprator],
	    		['category_id' => $id_category]
	    	);

	    	if($insert_oprator) {
	    		echo "Sukses insert oprator ($desc) + kategori <br>";
	    	}



		    
		}
    }

    

    public function irvankede() {
    	$key = "38fdca-18993d-5661f1-95576b-5f7f51"; // API KEY MY
		$id = '9018'; // API ID MU
		$postdata = "api_id=$id&api_key=$key";
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://irvankede-smm.co.id/api/services");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		//echo $chresult;
		curl_close($ch);
		$json_result = json_decode($chresult);
		// dd($json_result->data);
		foreach($json_result->data as $data) {
			$category= $data->category;
			$id = $data->id;
			$service = $data->name;
			$min_order =$data->min;
			$max_order = $data->max;
			$price = $data->price;
			$note = $data->note;

			$provider = Provider::where("name","IRV")->first();
			if(!$provider) dd("TIDAK ADA PROVIDER BERNAMA 'IRV'");

			$check_category = Service_cat::updateOrCreate(
				['name'=>$category, 'type'=>'SOSMED']
			);

			$insert = Service::updateOrCreate(
				['pid'=>$id],
				[
					'name' => $service,
					'category_id' => $check_category->id,
					'note' => $note,
					'min' => $min_order,
					'max' => $max_order,
					'price'=>$price,
					'price_oper'=>$price,
					'keuntungan'=>0,
					'type'=>'Basic',
					'status'=>'Active',
					'pid'=>$id,	
					'provider_id'=>$provider->id
				]
			);

			echo "SUKSES INSERT <br> Name: $service <br> Category: $category <br> Price: $price <br><br><br>";
		}
    }



    public function jap() {
    	$key = "85bbc512fb2c739666585d72fe13d56e"; // your api key
		$postdata = "key=$key&action=services";

		$provider = Provider::where("name","JAP")->first();
		if(!$provider) dd("TIDAK ADA PROVIDER BERNAMA 'JAP'");

		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://justanotherpanel.com/api/v2");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		//echo $chresult;
		curl_close($ch);
		$json_result = json_decode($chresult);
		dd($json_result);
		foreach($json_result as $data) {
			$category = $data->category;
			$id =$data->service;
			$service = $data->name;
			$min_order =$data->min;
			$max_order = $data->max;
			$price = $data->rate;
			$type = $data->type;

			$rate = 15000;
			$idr_price = $price * $rate;


			$check_category = Service_cat::updateOrCreate(
				['name'=>$category, 'type'=>'SOSMED']
			);

			if($type == 'Default') {
				$newtype = 'Basic';
			}else if($type == 'Custom Comments') {
				$newtype = 'Custom Comment';
			}else{
				$newtype = 'Basic';
			}

			$service = Service::updateOrCreate(
				['pid'=>$id],
				[
					'name'=>$service,
					'type'=>$newtype,
					'min'=>$min_order,
					'max'=>$max_order,
					'price'=> $idr_price,
					'keuntungan' => 0,
					'category_id' => $check_category->id,
					'note'=>'Harap isi sesuai ketentuan yang berlaku',
					'price_oper'=>$idr_price,
					'status'=>'Active',
					'provider_id' => $provider->id
				]
			);

			echo "SUKSES INSERT! <br> Nama: $service <br> Category: $category <br> Price: $idr_price <br<br>";
 		}
    }

    public function bulkfollows() {
    	$provider = Provider::where("name","BULKFOLLOWS")->first();
		if(!$provider) dd("TIDAK ADA PROVIDER BERNAMA 'BULKFOLLOWS'");
    	$services = Bulkfollows::services();
    	// dd($services);
    	// dd($service->min);
    	foreach($services as $data) {
    		$category = $data->category;
			$id = $data->service;
			$service = $data->name;
			$min_order = $data->min;
			$max_order = $data->max;
			$price = $data->rate;
			$type = $data->type;

			$rate = 15000;
			$idr_price = $price * $rate;


			$check_category = Service_cat::updateOrCreate(
				['name'=>$category, 'type'=>'SOSMED']
			);



			if($type == 'Default') {
				$newtype = 'Basic';
			}else if($type == 'Custom Comments') {
				$newtype = 'Custom Comment';
			}else{
				$newtype = 'Basic';
			}


			$service = Service::updateOrCreate(
				['pid'=>$id],
				[
					'name'=>$service,
					'type'=>$newtype,
					'min'=>$min_order,
					'max'=>$max_order,
					'price'=> $idr_price,
					'keuntungan' => 0,
					'category_id' => $check_category->id,
					'note'=>'Harap isi sesuai ketentuan yang berlaku',
					'price_oper'=>$idr_price,
					'status'=>'Active',
					'provider_id' => $provider->id
				]
			);

			echo "SUKSES INSERT! <br> Nama: $service->name <br> Category: $category <br> Price: $idr_price <br<br>";
    	}
    }

    public function gatenz() {
    	$provider = Provider::where("name","GATENZ")->first();
		if(!$provider) dd("TIDAK ADA PROVIDER BERNAMA 'GATENZ'");
    	$services = Bulkfollows::services();

    	$postdata = "api_key=$provider->api_key&action=services";
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.gatenz-panel.com/api/");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		//echo $chresult;
		curl_close($ch);
		$json_result = json_decode($chresult);
		$i = 0;
    	foreach($json_result as $data) {
    		if($i == 0) {
    			$i++;
    			continue;
    		}
    		$category = $data->category;
			$id = $data->id;
			$service = $data->name;
			$min_order = $data->min;
			$max_order = $data->max;
			$price = $data->price;
			$note = $data->note;
			$keuntungan = 0;
			


			$check_category = Service_cat::updateOrCreate(
				['name'=>$category, 'type'=>'SOSMED']
			);



			$service = Service::updateOrCreate(
				['pid'=>$id],
				[
					'name'=>$service,
					'type'=>"Basic",
					'min'=>$min_order,
					'max'=>$max_order,
					'price'=> $price,
					'keuntungan' => 0,
					'category_id' => $check_category->id,
					'note'=>$note,
					'price_oper'=>$price,
					'status'=>'Active',
					'provider_id' => $provider->id
				]
			);

			echo "SUKSES INSERT! <br> Nama: $service->name <br> Category: $category <br> Price: $price <br<br>";
    	}
    }

    public function smmindo() {
    	
    }
}
