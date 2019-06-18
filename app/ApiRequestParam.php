<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiRequestParam extends Model
{
    protected $fillable = [
        'param_key',
        'param_value',
        'param_type',
        'api_type',
        'api_id',
    ];
}
