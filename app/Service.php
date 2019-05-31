<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $fillable = ['name','category_id','note','min','max','price','price_oper','keuntungan','type','status','pid','provider_id'];
    public function category(){
    	return $this->belongsTo('App\Service_cat', 'category_id');
    }
    public function provider(){
    	return $this->belongsTo('App\Provider', 'provider_id');
    }
}
