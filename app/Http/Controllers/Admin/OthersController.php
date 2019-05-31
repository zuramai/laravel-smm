<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\Environtment;
use App\Http\Controllers\Controller;
use App\Service_cat;
use App\Service;
use App\Services_pulsa;
use App\User;
use App\Activity;
use App\Balance_history;
use App\Custom_price;
use Carbon\Carbon;
use App\Config;
use Alert;
use Auth;
use DB;


class OthersController extends Controller
{
    public function custom_price() {
        $custom_prices = Custom_price::orderBy('id','DESC')->simplePaginate(15);
        return view('developer.custom_price', compact('custom_prices'));
    }

    public function custom_price_post(Request $r) {
        $r->validate([
            'email' => 'required|exists:users,email',
            'serviceid' => 'required|exists:services,id',
        ],[
            'serviceid.exists' => 'Layanan tidak ditemukan'
        ]);
        $email = $r->email;

        $sid = $r->serviceid;

        $service = Service::find($r->serviceid);
        $r->validate([
            'potongan' => 'required|numeric|max:'.$service->price+$service->keuntungan
        ],[
            'potongan.min' => 'Jumlah potongan tidak boleh melebihi harga layanan'
        ]);
        $potongan = $r->potongan;

        // GET USER ID
        $user = User::where('email',$email)->first();
        $user_id = $user->id;

        $ins = new Custom_price;
        $ins->user_id = $user_id;
        $ins->service_id = $sid;
        $ins->potongan = $potongan;
        $ins->save();

        session()->flash('success',"Sukses tambah data! <br><b>Email:</b> $email<br> <b>Service:</b> $sid<br> <b>Jumlah Potongan:</b> $potongan");
        Alert::success('Sukses tambah data!','Sukses');
        return redirect()->back();
    }

    public function custom_price_delete(Request $r) {
        $r->validate([
            'id'=>'required|exists:custom_prices,id'
        ]);
        $id = $r->id;

        Custom_price::find($id)->delete();
        session()->flash('success','Sukses hapus data!');
        Alert::success('Sukses hapus!','success');
        return redirect()->back();
    }


    public function configuration() {
        return view('developer.configuration.index', compact('web_config'));   
    }

    public function configuration_update(Request $r) {
        $r->validate([
            'web_title' => 'required',
            'web_description' => 'required',
            'login_desc' => 'required',
            
            'add_member_price' => 'required|integer|min:0',
            'add_agen_price' => 'required|integer|min:0',
            'add_reseller_price' => 'required|integer|min:0',
            'add_admin_price' => 'required|integer|min:0',

            'member_balance' => 'required|integer|min:0',
            'agen_balance' => 'required|integer|min:0',
            'reseller_balance' => 'required|integer|min:0',
            'admin_balance' => 'required|integer|min:0',

            'min_voucher' => 'required|integer|min:0',
            'max_voucher' => 'required|integer|min:0',
            'min_deposit' => 'required|integer|min:0',

            'web_logo' => 'nullable|image',
            'web_logo_dark' => 'nullable|image',
            'favicon' => 'nullable|image',

        ]); 

        $login_desc = str_replace(["\n","\r"],"",$r->login_desc);;
        $login_desc = str_replace(["                                            "],"",$login_desc);
        $login_desc = str_replace('"',"'",$login_desc);;

        if($r->file('web_logo') != null) {
            $photoname = Str::random(10);
            $web_logo_url = $r->file('web_logo')->move(public_path('img/logo'), $photoname);
            $logo_url = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_LOGO_URL"],['value'=>$logo_url]);
        }
        if($r->file('web_logo_dark') != null) {
            $photoname = Str::random(10);
            $web_logo_url_dark = $r->file('web_logo_dark')->move(public_path('img/logo'), $photoname);
            $logo_url_dark = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_LOGO_URL_DARK"],['value'=>$logo_url_dark]);
        }
        if($r->file('favicon') != null) {
            $photoname = Str::random(10);
            $favicon = $r->file('favicon')->move(public_path('img/logo'), $photoname);
            $favicon_url = asset('img/logo/'.$photoname);
            Config::updateOrCreate(['name'=>"WEB_FAVICON_URL"],['value'=>$favicon_url]);
        }

        Config::updateOrCreate(['name'=>"APP_NAME"],['value'=>$r->web_name]);
        Config::updateOrCreate(['name'=>"WEB_TITLE"],['value'=>$r->web_title]);
        Config::updateOrCreate(['name'=>"WEB_DESCRIPTION"],['value'=>$r->web_description]);
        Config::updateOrCreate(['name'=>'WEB_AUTH_DESCRIPTION'],['value'=>$login_desc]);

        Config::updateOrCreate(['name'=>"ADD_MEMBER_PRICE"],['value'=>$r->add_member_price]);
        Config::updateOrCreate(['name'=>"ADD_AGEN_PRICE"],['value'=>$r->add_agen_price]);
        Config::updateOrCreate(['name'=>"ADD_RESELLER_PRICE"],['value'=>$r->add_reseller_price]);
        Config::updateOrCreate(['name'=>"ADD_ADMIN_PRICE"],['value'=>$r->add_admin_price]);
    
        Config::updateOrCreate(['name'=>"MEMBER_BALANCE"],['value'=>$r->member_balance]);
        Config::updateOrCreate(['name'=>"AGEN_BALANCE"],['value'=>$r->agen_balance]);
        Config::updateOrCreate(['name'=>"RESELLER_BALANCE"],['value'=>$r->reseller_balance]);
        Config::updateOrCreate(['name'=>"ADMIN_BALANCE"],['value'=>$r->admin_balance]);
        
        Config::updateOrCreate(['name'=>"MIN_VOUCHER"],['value'=>$r->min_voucher]);
        Config::updateOrCreate(['name'=>"MAX_VOUCHER"],['value'=>$r->max_voucher]);
        Config::updateOrCreate(['name'=>"MIN_DEPOSIT"],['value'=>$r->min_deposit]);

        
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');

        session()->flash('success','Sukses mengubah konfigurasi website!');
        return redirect()->back();
    }

}

