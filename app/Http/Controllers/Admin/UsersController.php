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
use App\Orders_pulsa;
use App\Staff;
use App\Oprator;
use App\Activity;
use App\Deposit;
use Alert;
use Carbon\Carbon;

class UsersController extends Controller
{
     public function manage_users(Request $r){
        $search = $r->get('search');
        $users = User::where('email','LIKE',"%$search%")->orWhere('name','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(10);
        $users->appends($r->only('search'));
        return view('developer.users.index', compact('users'));
    }
    public function add_users() {
        return view('developer.users.add');
    }
    public function users_detail($id) {
        $user = User::where('id',$id);
        return view('developer.users.detail', compact('user'));
    }
    public function add_users_post(Request $r) {
        $r->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'balance' =>'integer',
            'password' => 'min:5',
            'level' => 'required'
        ]);
        $name = $r->name;
        $email = $r->email;
        $password = Hash::make($r->password);
        $balance = $r->balance;
        $level = $r->level;
        $api_key = Hash::make(Str::random(5));
        
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->balance = $balance;
        $user->level = $level;
        $user->status = 'Active';
        $user->api_key = $api_key;
        $user->uplink = null;
        $user->save();

        session()->flash('success','Sukses tambah pengguna!');
        return redirect('developer/users');
        
    }
    public function edit_users($id){
        $user = User::where('id',$id)->first();
        return view('developer.users.edit', compact('user'));
    }
    public function update_users(Request $r, $id) {
        $user = User::where('id',$id)->first();
        $r->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'balance' =>'numeric|min:0',
            'password' => 'min:5',
            'level' => 'required',
            'status' => 'required'
        ]);
        $name = $r->name;
        $email = $r->email;
        $password = $r->password;
        $balance = $r->balance;
        $level = $r->level;
        $status = $r->status;

        if($password != $user->password) {
            $newpass = Hash::make($password);
        }else{
            $newpass = $password;
        }

        $update = User::find($id);
        $update->name = $name;
        $update->email = $email;
        $update->password = $newpass;
        $update->balance = $balance;
        $update->level = $level;
        $update->update();
        
        session()->flash('success','Sukses ubah pengguna!');
        return redirect('developer/users');
    }
    public function delete_users(Request $r){
        $id = $r->id;
        $del = User::find($id);
        $del->delete();
        
        session()->flash('success','Sukses hapus pengguna!');
        return redirect()->back();
    }
}
