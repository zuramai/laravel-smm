<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Order;
use App\Provider;
use App\Activity;
use App\Balance_history;
use App\Custom_price;
use Alert;
use Carbon\Carbon;

class ServiceSosmedController extends Controller
{
    public function services(Request $r){
        $search = $r->get('search');
        $service = Service::where('name','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(15);
        $service->appends($r->only('search'));
        return view('developer.services.index', compact('service'));
    }
    public function add_services(){
        $provider = Provider::where('type','SOSMED')->get();
        $category = Service_cat::where('type','SOSMED')->get();
        return view('developer.services.add', compact('category','provider'));
    }
    public function post_add_services(Request $r){
        $r->validate([
            'name'=>'required',
            'category'=>'required',
            'note'=>'required',
            'min'=>'required',
            'max'=>'required',
            'price'=>'required',
            'keuntungan'=>'required',
            'price_oper'=>'required',
            'pid'=>'required',
            'type' => 'required|in:Basic,Custom Comment,Comment Likes',
            'provider'=>'required',
        ]);
        $name = $r->name;
        $category = $r->category;
        $note = $r->note;
        $min = $r->min;
        $max = $r->max;
        $type = $r->type;
        $price = $r->price;
        $keuntungan = $r->keuntungan;
        $price_oper = $r->price_oper;
        $pid = $r->pid;
        $provider = $r->provider;

        $service = new Service;
        $service->name = $name;
        $service->category_id = $category;
        $service->note = $note;
        $service->min = $min;
        $service->max = $max;
        $service->price = $price;
        $service->type = $type;
        $service->price_oper = $price_oper;
        $service->keuntungan = $keuntungan;
        $service->provider_id = $provider;
        $service->pid = $pid;
        $service->save();

        session()->flash('success','Success add service!');
        return redirect('developer/services');
    }
    public function delete_services(Request $r) {
        $service = Service::find($r->id);
        $service->delete();

        session()->flash('success','Sukses hapus layanan!');
        return redirect()->back();
    }
    public function detail_services($id) {
        $service = Service::findOrFail($id);
        return view('developer.services.detail',compact('service'));
    }
    public function edit_services($id){
        $provider = Provider::where('type','SOSMED')->get();
        $category = Service_cat::where('type','SOSMED')->get();
        $service = Service::where('id',$id)->first();
        return view('developer.services.edit', compact('service','provider','category'));
    }

    public function update_services($id,Request $r){
        $r->validate([
            'name'=>'required',
            'category'=>'required',
            'note'=>'required',
            'min'=>'required',
            'max'=>'required',
            'price'=>'required',
            'keuntungan'=>'required',
            'price_oper'=>'required',
            'type' => 'required|in:Basic,Custom Comment,Comment Likes',
            'pid'=>'required',
            'provider'=>'required',
        ]);
        $name = $r->name;
        $category = $r->category;
        $type = $r->type;
        $note = $r->note;
        $min = $r->min;
        $max = $r->max;
        $price = $r->price;
        $keuntungan = $r->keuntungan;
        $price_oper = $r->price_oper;
        $pid = $r->pid;
        $provider = $r->provider;
        $status = $r->status;
        
        $service = Service::find($id);
        $service->name = $name;
        $service->category_id = $category;
        $service->note = $note;
        $service->min = $min;
        $service->max = $max;
        $service->price = $price;
        $service->type = $type;
        $service->price_oper = $price_oper;
        $service->keuntungan = $keuntungan;
        $service->provider_id = $provider;
        $service->pid = $pid;
        $service->status = $status;
        $service->save();

        session()->flash('success','Success update service!');
        return redirect('developer/services');
    }

}
