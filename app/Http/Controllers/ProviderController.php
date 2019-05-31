<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;

class ProviderController extends Controller
{
    public function index() {
    	$prov = Provider::orderBy('id','desc')->paginate(10);
    	return view('developer.providers.index', compact('prov'));
    }

    public function add() {
    	return view('developer.providers.add');
    }

    public function add_post(Request $r){
    	$prov = new Provider;
    	$prov->name = $r->name;
    	$prov->api_key = $r->key;
        $prov->link = $r->link;
    	$prov->type = $r->type;
    	$prov->save();

    	session()->flash('success','Sukses tambah provider!');
    	return redirect('developer/providers');
    }

    public function edit($id) {
    	$prov = Provider::find($id);
        
    	return view('developer.providers.edit',compact('prov'));
    }

    public function update($id,Request $r) {
    	$prov = Provider::find($id);
    	$prov->name = $r->name;
    	$prov->api_key = $r->key;
    	$prov->link = $r->link;
    	$prov->type = $r->type;
        $prov->save();

    	session()->flash("success",'Sukses update data provider!');
    	return redirect('developer/providers');
    }

    public function delete(Request $r) {
    	$prov = Provider::find($r->id);
    	$prov->delete();

    	session()->flash('success','Sukses hapus data!');
    	return redirect()->back();
    }
}
