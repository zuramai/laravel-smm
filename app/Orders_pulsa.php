<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders_pulsa extends Model
{
    public function service() {
    	return $this->belongsTo('App\Services_pulsa', 'service_id');
    }

    public function user() {
    	return $this->belongsTo('App\User','user_id');
    }
}
