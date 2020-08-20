<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\Activity;
use App\Balance_history;
use App\Deposit;
use App\Deposit_method;
use App\Invitation_code;
use Alert;
use Carbon\Carbon;

class DepositController extends Controller
{
    public function manage_deposit(Request $r){
        $search = $r->get('search');
        $deposits = Deposit::where('id','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(10);
        $deposits->appends($r->only('search'));
        return view('developer.deposits.index', compact('deposits'));
    }
    public function accept_deposit(Request $r){
        $id = $r->id;
        $deposit = Deposit::find(   $id);
        $get_balance = $deposit->get_balance;
        $id_user = $deposit->user_id;
        $deposit->status = 'Success';
        $deposit->save();

        $user = User::find($id_user);
        $user->balance += $get_balance;
        $user->save();

        $balance_history = new Balance_history;
        $balance_history->user_id = $id_user;
        $balance_history->action = "Add Balance";
        $balance_history->quantity = $get_balance;
        $balance_history->desc = "Saldo ditambahkan sebesar ".config('web_config')['CURRENCY_CODE']." ".$get_balance;
        $balance_history->save();               

        Alert::success('Sukses menerima deposit!','Sukses!');
        return redirect()->back();
    }
    public function decline_deposit(Request $r){
        $id = $r->id;
        $deposit = Deposit::find($id);
        $deposit->status = 'Canceled';
        $deposit->save();


        session()->flash('success','Sukses tolak deposit');
        Alert::success('Sukses tolak deposit','Sukses');
        return redirect()->back();
    }
}
