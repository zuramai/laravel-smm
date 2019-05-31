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
use App\News;
use App\Activity;
use Alert;
use Carbon\Carbon;

class NewsController extends Controller
{
     public function manage_news(){
        $news = News::orderBy('id','desc')->simplePaginate(10);
        return view('developer.news.index', compact('news'));
    }
    public function add_news(){
        return view('developer.news.add');
    }
    public function add_news_post(Request $r) {

        $type = $r->type;
        $title = $r->title;
        $content = $r->content;

        $validate = $r->validate([
            'type' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);



        $news = new News;
        $news->title = $title;
        $news->type = $type;
        $news->content = $content;
        $news->save();

        Alert::success('Sukses menambahkan berita!', 'Sukses!');
        return redirect('/developer/news');
    }
    public function edit_news($id){
        $news = News::find($id);
        return view('developer.news.edit', compact('news'));
    }
    public function update_news(Request $r, $id){
        $news = News::find($id);
        $news->type = $r->type;
        $news->title = $r->title;
        $news->content = $r->content;
        $news->save();

        Alert::success('Sukses update berita!','Sukses!');
        return redirect('/developer/news');

    }
    public function delete_news(Request $r) {
        $news = News::find($r->id);
        $news->delete();

        Alert::success('Sukses hapus berita!','Success!');
        session()->flash('success','Sukses hapus berita!');
        return redirect('developer/news');
    }
}
