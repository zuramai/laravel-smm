<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Ticket_content;
use App\User;
use App\Activity;
use Auth;
use Alert;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index() {
    	$tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
    	return view('ticket.index',compact('tickets'));
    }

    public function detail($id) {
        $data_ticket = Ticket::findOrFail($id);
        if($data_ticket->user_id != Auth::user()->id) {
            return redirect()->back();
        }
        $data_ticket->read_by_user = 1;
        $data_ticket->save();
    	$ticket = Ticket::find($id)->content;
        // dd($ticket);
    	return view('ticket.detail', compact('ticket','data_ticket'));
    }

    public function add_view() {
    	return view('ticket.add');
    }

    public function add(Request $r) {
        $r->validate([
            'title' => 'required|min:5|string',
            'content' => 'required|min:20',
        ]);

        $ticket = new Ticket;
        $ticket->subject = $r->title;
        $ticket->user_id = Auth::user()->id;
        $ticket->status = 'Open';
        $ticket->read_by_user = '1';
        $ticket->read_by_admin = '0';
        $ticket->save();

        $content = new Ticket_content;
        $content->user_id = Auth::user()->id;
        $content->ticket_id = $ticket->id;
        $content->content = $r->content;
        $content->save();


        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->type = "Ticket";
        $activity->description = "Pembuatan tiket baru dengan id ".$ticket->id;
        $activity->user_agent = $r->header('User-Agent');
        $activity->ip = $r->ip();
        $activity->save();

        Alert::success('Sukses membuat tiket baru','Sukses!');

        session()->flash('success','Sukses membuat tiket! Silahkan tunggu balasan admin maksimal 1x24 jam');
        return redirect('ticket');
    }

    public function detail_add(Request $r, $id) {
        $ticket = Ticket::find($id);
        $ticket->status = 'User Reply';
        $ticket->save();

        $content = new Ticket_content;
        $content->user_id = Auth::user()->id;
        $content->ticket_id =  $id;
        $content->content = $r->content;
        $content->save();

        $activity = new Activity;
        $activity->user_id = Auth::user()->id;
        $activity->type = "Ticket";
        $activity->description = "Membalas tiket ".$ticket->subject;
        $activity->user_agent = $r->header('User-Agent');
        $activity->ip = $r->ip();
        $activity->save();

        Alert::success('Sukses membalas tiket','Sukses!');
        return redirect()->back();
    }
}
