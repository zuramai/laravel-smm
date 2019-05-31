<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function content() {
    	return $this->hasMany('App\Ticket_content');
    }

    public function user() {
    	return $this->belongsTo('App\User','user_id');
    }
}
