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
use Alert;
use Carbon\Carbon;

class DepositMethodController extends Controller
{
    public function deposit_method(){
        $methods = Deposit_method::simplePaginate(10);
        return view('developer.deposits.method.index', compact('methods'));
    }
    public function add_deposit_method(){
        return view('developer.deposits.method.add');
    }
    public function post_deposit_method(Request $r){

        $r->validate([
            'name' => 'required',
            'type' => 'required',
            'rate' => 'required',
            'rekening' => 'required',
            'keterangan' => 'required',
        ]);
        $name = $r->name;
        $type = $r->type;
        $rate = $r->rate;
        $keterangan = $r->keterangan;
        $rekening = $r->rekening;

        

        $method = new Deposit_method;
        $method->name = $name;
        $method->type = $type;
        $method->rate = $rate;
        $method->data = $rekening;
        $method->note = $keterangan;
        $method->status = 'Active';
        $method->save();


        Alert::success('Sukses tambah metode deposit!','Sukses!');
        return redirect('developer/deposit/method');
    }
    public function edit_deposit_method($id){
        $method = Deposit_method::find($id);
        return view('developer.deposits.method.edit', compact('method'));
    }
    public function update_deposit_method($id,Request $r){
        $r->validate([
            'name' => 'required',
            'type' => 'required',
            'rate' => 'required',
            'rekening' => 'required',
            'keterangan' => 'required',
        ]);
        $name = $r->name;
        $type = $r->type;
        $rate = $r->rate;
        $keterangan = $r->keterangan;
        $rekening = $r->rekening;
        $status = $r->status;

        $method = Deposit_method::find($id);
        $method->name = $name;
        $method->type = $type;
        $method->rate = $rate;
        $method->data = $rekening;
        $method->note = $keterangan;
        $method->status = $status;
        $method->save();


        Alert::success('Sukses ubah metode deposit!','Sukses!');
        return redirect('developer/deposit/method');
    }

    public function delete_deposit_method(Request $r) {
        $r->validate(['id'=>'required']);
        Deposit_method::find($r->id)->delete();

        Alert::success('Sukses hapus metode deposit!','Sukses!');
        return redirect()->back();
    }
}
