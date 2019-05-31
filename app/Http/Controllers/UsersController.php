<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Alert;
use Validator;
use Hash;
use Auth;

class UsersController extends Controller
{
	public function __construct() {
		return $this->middleware('auth');
	}

    public function index() {
    	return redirect('users/settings');
    }

    public function setting() {
    	$id = auth()->user()->id;
    	$user = User::where('id',$id)->first();
    	return view('users.settings', compact('user'));
    }

    public function update(Request $r) {
    	if($r->has('name')) {
            $name = $r->name;
    		$phone = $r->phone;
            $r->validate([
                'name'=>['required', 'string', 'max:255'],
                'phone'=>['required','numeric','digits_between:5,15']
            ]);
    		$datetime = date('YmdHis');
    		if($r->file('photo') != null) {
                $r->validate([
                    'photo' => 'image'
                ]);
    			$photoname = $datetime;
    			$r->file('photo')->move(public_path('img/users'), $photoname);

    			$user = User::find(auth()->user()->id);
    			$user->photo = $photoname;
                $user->phone = $phone;
    			$user->name = $name;
    			$user->save();

				Alert::success('Sukses ubah data pengguna', 'Success');
    			return redirect()->back();

    		}else{
                $name = $r->name;
                $phone = $r->phone;
                $user = User::find(auth()->user()->id);
                $user->phone = $phone;
                $user->name = $name;
                $user->save();

                session()->flash('success_profile','Sukses ubah data pengguna!');
                Alert::success('Sukses ubah data pengguna', 'Success');
                return redirect()->back();
            }
    	}else if($r->has('key')) {
    		$user = User::find(auth()->user()->id);
    		$user->api_key = Str::random(40);
    		$user->save();

    		Alert::success('Sukses update API Key','Success');
    		return redirect()->back();
    	}else if($r->has('oldpassword')){
    		$validate = Validator::make($r->all(),[
    			'oldpassword' => 'required',
    			'newpassword' => 'required|confirmed',
    		]);

    		$oldpass = $r->oldpassword;
    		$newpass = $r->newpassword;
    		$confirm = $r->newpassword_confirmation;

    		if(!(Hash::check($oldpass, Auth::user()->password))) {
	    		Alert::error('Masukkan password sekarang dengan benar!','Gagal');
    			return redirect()->back();
    		}

    		if($validate->fails()) {
    			dd($validate->messages());	
    			Alert::error("Harap masukkan data dengan benar",'Gagal');
    			return redirect()->back();
    		}

    		$hashed = Hash::make($newpass);
    		$user = User::find(Auth::user()->id);
    		$user->password = $hashed;
    		$user->save();

    		Alert::success("Sukses ubah password!", 'Sukses!');
    		return redirect()->back();	
    	} else{
    		Alert::error('Server sedang sibuk','Failed');
    		return redirect()->back();


    	}
    }
}
