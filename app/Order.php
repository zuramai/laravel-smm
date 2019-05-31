<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function service(){
    	return $this->belongsTo('App\Service', 'service_id');
    }
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
