<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use DB;
use App\User;
use App\Staff;
use App\Activity;
use Alert;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function staff() {
        $staff = Staff::simplePaginate(5);
        return view('developer.staff.index', compact('staff'));
    }

    public function add_staff() {
        return view('developer.staff.add');
    }

    public function add_staff_post(Request $r) {
        $r->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' =>'required|email',
            'photo' => 'required',
            'level' => 'required'
        ]);
        
        if($r->hasFile('photo')){
            $datetime = date('YmdHis');
            $photoname = $datetime."-".$r->file('photo')->getClientOriginalName();
            $r->file('photo')->move(public_path('img/staff'), $photoname);
        }

        $staff = new Staff;
        $staff->name = $r->name;
        $staff->phone = $r->phone;
        $staff->level = $r->level;
        $staff->email = $r->email;
        $staff->picture = $photoname;

        if($r->has('fb_name')) {
            $staff->facebook_name = $r->fb_name;
            $staff->facebook_url = $r->fb_link;
        }

        $staff->save();
        
        Alert::success('Sukses tambah staff!','Sukses!');
        return redirect(url('developer/staff'));
    }

    public function edit_staff($id) {
        $staff = Staff::findOrFail($id);
        return view('developer.staff.edit', compact('staff'));
    }

    public function update_staff(Request $r, $id) {
        $r->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' =>'required|email',
            'level' => 'required'
        ]);
        

        $staff = Staff::find($id);
        $staff->name = $r->name;
        $staff->phone = $r->phone;
        $staff->level = $r->level;
        if($r->hasFile('photo')){
            $datetime = date('YmdHis');
            $photoname = $datetime."-".$r->file('photo')->getClientOriginalName();
            $r->file('photo')->move(public_path('img/staff'), $photoname);
            $staff->picture = $photoname;
        }
        $staff->email = $r->email;

        if($r->has('fb_name')) {
            $staff->facebook_name = $r->fb_name;
            $staff->facebook_url = $r->fb_link;
        }

        $staff->save();
        
        Alert::success('Sukses update staff!','Sukses!');
        return redirect(url('developer/staff'));
    }

    public function delete_staff(Request $r){
        $id = $r->id;

        Staff::find($id)->delete();
        Alert::success('Sukses hapus staff!','Sukses!');
        return redirect()->back();
    }
}
