<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oprator extends Model
{
    protected $table = "service_pulsa_operators";

    public function category() {
    	return $this->belongsTo('App\Service_cat', 'category_id');
    }

    protected $fillable = [
      	'name', 'category_id'
    ];
}
