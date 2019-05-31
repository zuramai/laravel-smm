<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Services_pulsa;

class PriceController extends Controller
{

    public function sosmed(Request $r) {
    	$search = $r->get('search');
    	$service = Service::orderBy('id','asc')->where('name','LIKE',"%$search%")->paginate(15);
    	$service->appends($r->only('search'));
    	return view('price.sosmed', compact('service'));
    }

    public function pulsa(Request $r) {
    	$search = $r->get('search');
    	$service = Services_pulsa::orderBy('id','asc')->where('name','LIKE',"%$search%")->paginate(15);
    	$service->appends($r->only('search'));
    	return view('price.pulsa', compact('service'));
    }

    public function detail_ajax(Request $r) {
        $sid = $r->service_id;
        $r->validate(['service_id'=>'required|exists:services,id']);
        
        $service = Service::find($sid);
        return response()->json([
            'name' => $service->name,
            'category' => $service->category->name,
            'note' => $service->note,
            'min' => $service->min,
            'max' => $service->max,
            'price' => $service->price+$service->keuntungan,
            'price_oper' => $service->price_oper+$service->keuntungan,
            'type' => $service->type,
            'status' => $service->status
        ],200);
    } 

    
}
