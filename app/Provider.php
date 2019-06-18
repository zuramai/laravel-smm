<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';
    
    protected $fillable = ['name','type','order_type','api_id'];

    public function api() {
    	return $this->belongsTo(API::class, 'api_id');
    }
}
