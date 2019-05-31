<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Orders_pulsa;
use App\Provider;
use App\Oprator;
use App\Activity;
use App\Balance_history;
use App\Deposit;
use App\Ticket;
use App\Ticket_content;
use App\Custom_price;
use Alert;
use Carbon\Carbon;


class ServicePulsaController extends Controller
{

	public function detail_services_pulsa() {

	}
	
    public function services_pulsa(Request $r) {
        $search = $r->get('search');
        $services = Services_pulsa::where('name','LIKE',"%$search%")->simplePaginate(10);
        $services->appends($r->only('search'));

        return view('developer.services.pulsa.index', compact('services'));
    }
    public function services_pulsa_add() {
        $category = Service_cat::where('type','PULSA')->get();
        $operator = Oprator::orderBy('name','ASC')->get();
        $provider = Provider::where('type','PULSA')->get();
        return view('developer.services.pulsa.add', compact('provider','category','operator'));
    }
    public function delete_services_pulsa(Request $r) {
        Services_pulsa::find($r->id)->delete();
        Alert::success('Sukses hapus layanan!','Sukses!');
        return redirect()->back();
    }
    public function edit_services_pulsa($id) {
        $service = Services_pulsa::find($id);
        $category = Service_cat::where('type','PULSA')->get();
        $operator = Oprator::orderBy('name','ASC')->get();
        $provider = Provider::where('type','PULSA')->get();
        return view('developer.services.pulsa.edit', compact('provider','category','operator','service'));
    }
    public function post_add_services_pulsa(Request $r) {
        $r->validate([
            'category' => 'required|exists:service_cats,id',
            'oprator' => 'required|exists:services_pulsa_operators,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'keuntungan' => 'required|numeric|min:0',
            'code' => 'required',
            'provider' => 'required|exists:providers,id'
        ]);

        $pulsa = new Services_pulsa;
        $pulsa->code = $r->code;
        $pulsa->oprator_id = $r->oprator;
        $pulsa->category_id = $r->category;
        $pulsa->name = $r->name;
        $pulsa->provider_id = $r->provider;
        $pulsa->price = $r->price;
        $pulsa->keuntungan = $r->keuntungan;
        $pulsa->status = 'Active';
        $pulsa->save();
        $kategori = $pulsa->category->name;
        session()->flash('success',"<b>Sukses tambah layanan!</b> <br> <b>Nama:</b> $r->name <br> <b>Kategori:</b> $kategori <br> <b>Harga:</b> Rp ".number_format($pulsa->price)." <br> <b>Keuntungan:</b> ".number_format($pulsa->keuntungan)." <br>");
        Alert::success('Sukses tambah layanan!','Sukses!');
        return redirect('developer/services_pulsa');
    }
    public function update_services_pulsa(Request $r,$id) {
        $r->validate([
            'category' => 'required|exists:service_cats,id',
            'oprator' => 'required|exists:services_pulsa_operators,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'keuntungan' => 'required|numeric|min:0',
            'code' => 'required',
            'provider' => 'required|exists:providers,id',
            'status'=>'required|in:Active,Not Active'
        ]);

        $pulsa = Services_pulsa::find($id);
        $pulsa->code = $r->code;
        $pulsa->oprator_id = $r->oprator;
        $pulsa->category_id = $r->category;
        $pulsa->name = $r->name;
        $pulsa->provider_id = $r->provider;
        $pulsa->price = $r->price;
        $pulsa->keuntungan = $r->keuntungan;
        $pulsa->status = $r->status;
        $pulsa->save();
        $kategori = $pulsa->category->name;

        session()->flash('success',"<b>Sukses ubah layanan!</b> <br> <b>Nama:</b> $r->name <br> <b>Kategori:</b> $kategori <br> <b>Harga:</b> Rp ".number_format($pulsa->price)." <br> <b>Keuntungan:</b> ".number_format($pulsa->keuntungan)." <br>");
        Alert::success('Sukses ubah layanan!','Sukses!');
        return redirect('developer/services_pulsa');
    }
}
