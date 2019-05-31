<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_cat extends Model
{
    protected $fillable = [
        'name', 'type', 'status'
    ];
}
