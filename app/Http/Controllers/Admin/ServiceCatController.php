<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use DB;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Provider;
use App\Activity;
use App\Balance_history;
use Alert;
use Carbon\Carbon;

class ServiceCatController extends Controller
{
	public function service_cat(Request $r){
        $search = $r->get('search');
        $service_cat = Service_cat::where('name','LIKE',"%$search%")->where('type','SOSMED')->simplePaginate(15);
        $service_cat->appends($r->only('search'));
        return view('developer.services.category.index', compact('service_cat'));
    }
    public function add_service_cat(){
        return view('developer.services.category.add');

    }
    public function post_add_service_cat(Request $r){
        $r->validate([
            'name'=>'required|min:5',
            'type'=>'required|min:1'
        ]);

        $name = $r->name;
        $type = $r->type;

        $cat = new Service_cat;
        $cat->name = $name;
        $cat->type = $type;
        $cat->save();

        session()->flash('success','Sukses tambah kategori!');
        return redirect(route('services_cat'));
    }
    public function delete_service_cat(Request $r){
        $id = $r->id;
        $find = Service_cat::find($id);
        $find->delete();

        session()->flash('success','Sukses delete kategori!');
        return redirect()->back();
    }
    public function edit_service_cat($id){
        $scat = Service_cat::where('id',$id)->first();
        return view('developer.services.category.edit', compact('scat'));
    }
    public function update_service_cat(Request $r,$id){
        $r->validate([
            'name'=>'required|min:5',
            'type'=>'required|min:1'
        ]); 

        $name = $r->name;
        $type = $r->type;
        $status = $r->status;

        $cat = Service_cat::findOrFail($id);
        $cat->name = $name;
        $cat->type = $type;
        $cat->status = $status;
        $cat->save();

        session()->flash('success','Sukses ubah kategori!');
        return redirect(route('services_cat'));   
    }
}
