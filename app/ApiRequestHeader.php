<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiRequestHeader extends Model
{
    protected $table = "api_request_headers";
    protected $fillable = [
    	'header_key',
    	'header_value',
    	'header_type',
    	'api_type',
    	'api_id'
    ];
}
