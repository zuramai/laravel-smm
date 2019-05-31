<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services_pulsa extends Model
{
    public function category() {
    	return $this->belongsTo('App\Service_cat', 'category_id');
    }
    public function oprator() {
    	return $this->belongsTo('App\Oprator', 'oprator_id');
    }
    public function provider() {
    	return $this->belongsTo('App\Provider','provider_id');
    }

    protected $fillable = [
		'code','name','oprator_id','category_id','price','status','provider_id'
    ];
}
