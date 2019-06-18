<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'poid',
		'user_id',
		'service_id',
		'target',
		'quantity',
		'start_count',
		'remains',
		'price',
		'status',
		'place_from',
		'notes',
		'refund'
	];
    public function service(){
    	return $this->belongsTo('App\Service', 'service_id');
    }
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
