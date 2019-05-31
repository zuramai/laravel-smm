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
use App\News;
use App\Provider;
use App\Staff;
use App\Oprator;
use App\Activity;
use App\Balance_history;
use App\Deposit;
use App\Ticket;
use App\Ticket_content;
use App\Deposit_method;
use App\Invitation_code;
use App\Custom_price;
use Alert;
use Carbon\Carbon;

class OrderSosmedController extends Controller
{
      

    public function manage_orders_sosmed(Request $r){
        $search = $r->get('search');
        $success = Order::where('status','Success');
        $total = Order::whereNotIn('status', ['Error','Partial'])->sum('price');
        
        $orders = Order::where('id','LIKE',"%$search%")->orWhere('target','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(10);
        $orders->appends($r->only('search'));
        return view('developer/orders/index', compact('orders','success','total'));
    }
    public function edit_orders_sosmed($id){
        $order = Order::where('id',$id)->first();
        return view('developer/orders/edit', compact('order'));
    }
    public function update_orders_sosmed(Request $r, $id){
        $r->validate([
            'status' => 'required',
            'start'=>'required',
            'remains'=>'required'
        ]);
        $order = Order::find($id);
        $order->start_count = $r->start;
        $order->remains = $r->remains;
        $order->status = $r->status;
        $order->save();

        session()->flash('success','Sukses ubah data order!');
        return redirect('developer/orders/sosmed');
    }
}
