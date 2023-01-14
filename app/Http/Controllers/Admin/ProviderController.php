<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Provider;
use App\Http\Controllers\Controller;
use App\API;
use App\ApiMapping;
use App\ApiRequestParam;
use App\ApiRequestHeader;
use App\ApiResponseLog;
use Alert;
use Session;

class ProviderController extends Controller
{
    public function index() {
    	$prov = Provider::orderBy('id','desc')->paginate(10);
    	return view('developer.providers.index', compact('prov'));
    }

    public function add() {
    	return view('developer.providers.add');
    }

    public function add_post(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'order_end_point' => 'required|url',
            'order_method' => 'required',
            'order_key' => 'required',
            'order_key_type' => 'required',
            'order_key_value' => 'required',
            'order_success_response' => 'required|json',
            'status_end_point' => 'required|url',
            'status_key' => 'required',
            'status_key_type' => 'required',
            'status_key_value' => 'required',
            'order_id_key' => 'required',
            'start_counter_key' => 'required',
            'status_key_equal' => 'required',
            'remains_key' => 'required',
            'process_all_order' => 'required',
            'status_success_response' => 'required|json',
            'type' => 'required|in:SOSMED,PULSA',
        ]);

        $api = API::create([
            'name' => $request->input('name'),
            'order_end_point' => $request->input('order_end_point'),
            'order_method' => $request->input('order_method'),
            'order_success_response' => str_replace('\t', '', $request->input('order_success_response')),
            'status_end_point' => $request->input('status_end_point'),
            'status_method' => $request->input('status_method'),
            'order_id_key' => $request->input('order_id_key'),
            'start_counter_key' => $request->input('start_counter_key'),
            'status_key' => $request->input('status_key_equal'),
            'remains_key' => $request->input('remains_key'),
            'process_all_order' => $request->input('process_all_order'),
            'status_success_response' => str_replace('\t', '', $request->input('status_success_response')),
            'link' => $request->input('order_end_point'),
            'type' => $request->input('type'),
        ]);
        $provider = Provider::create([
            'name' => $request->name,
            'type' => $request->type,
            'order_type' => "API",
            'api_id' => $api->id,
        ]);

        $header_order_keys = $request->input('header_order_key');
        $header_order_key_values = $request->input('header_order_key_value');

        if(!empty($header_order_keys) && !empty($header_order_key_values)) {
            for($i=0; $i < count($header_order_keys); $i++) {
                if(empty($header_order_keys[$i])) continue;
                ApiRequestHeader::create([
                    "header_key" => trim($header_order_key_values[$i]),
                    "header_value" => trim($header_order_key_values[$i]),
                    "header_type" => 'custom',
                    "api_type" => "order",
                    "api_id" => $api->id
                ]);
            }
        } 

        // Order place Parameters
        $order_keys = $request->input('order_key');
        $order_key_values = $request->input('order_key_value');
        $order_key_types = $request->input('order_key_type');

        for ($i = 0; $i < count($order_keys); $i++) {
            ApiRequestParam::create([
                'param_key' => trim($order_keys[$i]),
                'param_value' => trim($order_key_values[$i]),
                'param_type' => trim($order_key_types[$i]),
                'api_type' => 'order',
                'api_id' => $api->id,
            ]);
        }

        // Order status Parameters
        $status_keys = $request->input('status_key');
        $status_key_values = $request->input('status_key_value');
        $status_key_types = $request->input('status_key_type');

        for ($i = 0; $i < count($status_keys); $i++) {
            ApiRequestParam::create([
                'param_key' => trim($status_keys[$i]),
                'param_value' => trim($status_key_values[$i]),
                'param_type' => trim($status_key_types[$i]),
                'api_type' => 'status',
                'api_id' => $api->id,
            ]);
        }

        $header_status_keys = $request->input('header_status_key');
        $header_status_key_values = $request->input('header_status_key_value');

        if(!empty($header_status_keys) && !empty($header_status_key_values)) {
            for($i=0; $i < count($header_status_keys); $i++) {
                if(empty($header_status_keys[$i])) continue;
                ApiRequestHeader::create([
                    "header_key" => trim($header_status_keys[$i]),
                    "header_value" => trim($header_status_key_values[$i]),
                    "header_type" => 'custom',
                    "api_type" => "status",
                    "api_id" => $api->id
                ]);
            }
        } 

        Session::flash('success', 'Sukses tambah provider!');
        Alert::success('Sukses tambah provider!','Sukses')->persistent('Tutup');
        return redirect('developer/providers');
    }

    public function edit($id) {
        $api = API::findOrFail($id);
        $content = '';
        $apiRequestHeader = ApiRequestHeader::where('api_id',$id)->get();
        $apiRequestParams = ApiRequestParam::where(['api_id' => $id])->get();
    	return view('developer.providers.edit',compact('api', 'content', 'apiRequestParams', 'apiRequestHeader'));
    }

    public function update($id,Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'order_end_point' => 'required|url',
            'order_method' => 'required',
            'order_key' => 'required',
            'order_key_type' => 'required',
            'order_key_value' => 'required',
            'order_success_response' => 'required|json',
            'status_end_point' => 'required|url',
            'status_key' => 'required',
            'status_key_type' => 'required',
            'status_key_value' => 'required',
            'order_id_key' => 'required',
            'start_counter_key' => 'required',
            'status_key_equal' => 'required',
            'remains_key' => 'required',
            'process_all_order' => 'required',
            'status_success_response' => 'required|json',
            'type' => 'required|in:SOSMED,PULSA',
        ]);

        API::findOrFail($id)->update([
            'name' => $request->input('name'),
            'order_end_point' => $request->input('order_end_point'),
            'order_method' => $request->input('order_method'),
            'order_success_response' => str_replace('\t', '', $request->input('order_success_response')),
            'status_end_point' => $request->input('status_end_point'),
            'status_method' => $request->input('status_method'),
            'order_id_key' => $request->input('order_id_key'),
            'start_counter_key' => $request->input('start_counter_key'),
            'status_key' => $request->input('status_key_equal'),
            'remains_key' => $request->input('remains_key'),
            'process_all_order' => $request->input('process_all_order'),
            'status_success_response' => str_replace('\t', '', $request->input('status_success_response')),
            'link' => $request->input('order_end_point'),
            'type' => $request->input('type'),
        ]);

        Provider::where('api_id', $id)->update(['type' => $request->type]);

        ApiRequestParam::where(['api_id' => $id])->delete();
        ApiRequestHeader::where(['api_id' => $id])->delete();

        // Place order params
        $order_keys = $request->input('order_key');
        $order_key_values = $request->input('order_key_value');
        $order_key_types = $request->input('order_key_type');

        for ($i = 0; $i < count($order_keys); $i++) {
            ApiRequestParam::create([
                'param_key' => trim($order_keys[$i]),
                'param_value' => trim($order_key_values[$i]),
                'param_type' => trim($order_key_types[$i]),
                'api_type' => 'order',
                'api_id' => $id,
            ]);
        }

        $header_order_keys = $request->input('header_order_key');
        $header_order_key_values = $request->input('header_order_key_value');

        if(!empty($header_order_keys) && !empty($header_order_key_values)) {
            for($i=0; $i < count($header_order_keys); $i++) {
                ApiRequestHeader::create([
                    "header_key" => trim($header_order_keys[$i]),
                    "header_value" => trim($header_order_key_values[$i]),
                    "header_type" => 'custom',
                    "api_type" => "order",
                    "api_id" => $id
                ]);
            }
        } 

        // Get status params
        $status_keys = $request->input('status_key');
        $status_key_values = $request->input('status_key_value');
        $status_key_types = $request->input('status_key_type');

        for ($i = 0; $i < count($status_keys); $i++) {
            ApiRequestParam::create([
                'param_key' => trim($status_keys[$i]),
                'param_value' => trim($status_key_values[$i]),
                'param_type' => trim($status_key_types[$i]),
                'api_type' => 'status',
                'api_id' => $id,
            ]);
        }

        $header_status_keys = $request->input('header_status_key');
        $header_status_key_values = $request->input('header_status_key_value');
        if(!empty($header_order_keys) && !empty($header_order_key_values)) {
            for($i=0; $i < count($header_status_keys); $i++) {
                ApiRequestHeader::create([
                    "header_key" => trim($header_status_keys[$i]),
                    "header_value" => trim($header_status_key_values[$i]),
                    "header_type" => 'custom',
                    "api_type" => "status",
                    "api_id" => $id
                ]);
            }
            
        }
        


    	session()->flash("success",'Sukses update data provider!');
    	return redirect('developer/providers');
    }

    public function delete(Request $r) {
    	$prov = API::findOrFail($r->id);
    	$prov->delete();

    	session()->flash('success','Sukses hapus provider!');
    	return redirect()->back();
    }
}
