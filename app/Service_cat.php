<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_cat extends Model
{
    protected $table = 'service_categories';
    protected $fillable = [
        'name', 'type', 'status'
    ];
}
