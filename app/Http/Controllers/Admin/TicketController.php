<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Provider;
use App\Staff;
use App\Activity;
use App\Ticket;
use App\Ticket_content;
use Alert;
use Carbon\Carbon;


class TicketController extends Controller
{
    public function ticket_index() {
        // $tickets = DB::table('tickets')->select("")->get();
        $tickets = Ticket::orderByRaw("(case status when 'User Reply' then 1 when 'Open' then 2 when 'Responded' then 4 when 'Closed' then 5 else 6 end)")->simplePaginate(10);
        return view('developer.tickets.index',compact('tickets'));
    }

    public function ticket_close(Request $r) 
    {
        $id = $r->id;

        $ticket = Ticket::find($id);
        $ticket->status = 'Closed';
        $ticket->save();

        Alert::success('Sukses menutup tiket');
        session()->flash('success','Sukses menutup tiket <b>'.htmlentities($ticket->subject)."</b>");
        return redirect()->back();
    }
    public function ticket_detail($id) {
        $data_ticket = Ticket::findOrFail($id);
        $data_ticket->read_by_admin = 1;
        $data_ticket->save();
        $ticket = Ticket::find($id)->content;
        // dd($ticket);
        return view('developer.tickets.detail', compact('ticket','data_ticket'));
    }

    public function ticket_detail_add(Request $r, $id) {
        $ticket = Ticket::find($id);
        $ticket->status = 'Responded';
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
