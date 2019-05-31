<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Auth;
use App\Invitation_code;

class InvitecodeController extends Controller
{
    public function invitation_code() {
        $code = Invitation_code::simplePaginate(10);
        return view('developer.invitation_code.index', compact('code'));
    }
    public function invitation_code_add_random(Request $r) {
        $code = new Invitation_code;
        $code->code = Str::random(10);
        $code->remains = 1;
        $code->status = 'Open';
        $code->save();

        Alert::success('Sukses menambahkan kode!','Success');
        return redirect()->back();
    }
    public function invitation_code_add(Request $r) {
        $code = new Invitation_code;
        $code->code = $r->code;
        $code->remains = $r->max;
        $code->status = 'Open';
        $code->save();

        Alert::success('Sukses menambahkan kode!','Success');
        return redirect()->back();
    }

    public function invitation_code_delete(Request $r) {
        $id = Invitation_code::find($r->id);
        $id->delete();

        Alert::success('Sukses menghapus kode!','Success');
        return redirect()->back();   
    }
}
