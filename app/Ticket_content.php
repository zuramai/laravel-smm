<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_content extends Model
{
    public function ticket() {
    	return $this->belongsTo('App\Ticket', 'ticket_id');
    }

    public function user() {
    	return $this->belongsTo('App\User','user_id');
    }
}
