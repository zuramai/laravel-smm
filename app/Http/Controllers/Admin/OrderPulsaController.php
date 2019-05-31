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

class OrderPulsaController extends Controller
{
    public function manage_orders_pulsa(Request $r){
        $search = $r->get('search');
        $orders = Orders_pulsa::where('id','LIKE',"%$search%")->orWhere('data','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(10);
        $orders->appends($r->only('search'));

        return view('developer.orders.pulsa.index', compact('orders'));
    }
    public function edit_orders_pulsa(Request $r, $id){
        $order = Orders_pulsa::find($id);
        return view('developer.orders.pulsa.edit', compact('order'));
    }
    public function update_orders_pulsa(Request $r,$id){
        $r->validate([
            'status' => 'required|in:Pending,Processing,Success,Error'
        ]);

        $sn = $r->sn;
        $status = $r->status;

        $orders = Orders_pulsa::find($id);
        $orders->sn = $sn;
        $orders->status = $status;
        $orders->save();

        Alert::success('Sukses update order!','Sukses!');
        return redirect('developer/orders/pulsa');
    }
}
