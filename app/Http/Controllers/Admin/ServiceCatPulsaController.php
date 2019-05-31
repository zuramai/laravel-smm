<?php

namespace App\Http\Controllers\Admin;

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
use Alert;
use Carbon\Carbon;

class ServiceCatPulsaController extends Controller
{
    public function service_cat_pulsa(Request $r) {
        $search = $r->get('search');
        $service_cat = Service_cat::where('type','PULSA')->where('name','LIKE',"%$search%")->orderBy('id','desc')->simplePaginate(15);
        $oprator = Oprator::orderBy('id','desc')->simplePaginate(15);
        return view('developer.services.category.pulsa.index', compact('service_cat','oprator'));
    }
    public function service_cat_pulsa_edit($id) {
        $scat = Service_cat::find($id);

        return view('developer.services.category.pulsa.edit', compact('scat'));
    }
    public function service_cat_pulsa_update(Request $r, $id) {
        $scat = Service_cat::find($id);
        $scat->name = $r->name;
        $scat->type = $r->type;
        $scat->status = $r->status;
        $scat->save();

        Alert::success('Sukses mengubah kategori!','Sukses!');
        return redirect(route('services_cat_pulsa'));
    }
    public function service_cat_pulsa_delete(Request $r) {
        $scat = Service_cat::find($r->id);
        $scat->delete();

        Alert::success('Sukses hapus kategori!','Sukses!');
        return redirect()->back();
    }
    public function service_cat_oprator_delete(Request $r) {
        $scat = Oprator::find($r->id);
        $scat->delete();

        Alert::success('Sukses hapus operator!','Sukses!');
        return redirect()->back();   
    }
    public function add_services_cat_pulsa() {
        return view('developer.services.category.pulsa.add');
    }
    public function services_cat_pulsa_add_post(Request $r) {
        $r->validate([
            'name'=>'required|min:2',
            'type'=>'required|min:1'
        ]);

        $name = $r->name;
        $type = $r->type;

        $cat = new Service_cat;
        $cat->name = $name;
        $cat->type = $type;
        $cat->save();

        Alert::success('Sukses tambah kategori!','Success');
        return redirect(route('services_cat_pulsa'));
    }
    public function operator_add() {
        $cat = Service_cat::where('type','PULSA')->get();
        return view('developer.services.category.pulsa.operator.add',compact('cat'));
    }
    public function operator_add_post(Request $r) {
        $r->validate([
            'name' => 'required',
            'category' => 'required'
        ]);

        $oprator = new Oprator;
        $oprator->name = $r->name;
        $oprator->category_id = $r->category;
        $oprator->save();

        Alert::success('Sukses menambah operator!','Sukses!');
        return redirect(route('services_cat_pulsa'));
    }
    public function operator_edit($id) {
        $cat = Service_cat::where('type','PULSA')->get();
        $oprator = Oprator::find($id);
        return view('developer.services.category.pulsa.operator.edit', compact('oprator','cat'));

    }
    public function operator_update(Request $r, $id){
        $r->validate([
            'name' => 'required',
            'category' => 'required'
        ]);

        $oprator = Oprator::find($id);
        $oprator->name = $r->name;
        $oprator->category_id = $r->category;
        $oprator->save();

        Alert::success('Sukses mengubah operator!','Sukses!');
        return redirect(route('services_cat_pulsa'));
    }
}
