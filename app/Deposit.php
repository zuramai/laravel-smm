<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    public function methods() {
    	return $this->belongsTo('App\Deposit_method', 'method');
    }
    public function user() {
    	return $this->belongsTo('App\User','user_id');
    }
}
