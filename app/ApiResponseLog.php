<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiResponseLog extends Model
{
    protected $fillable = [
        'order_id',
        'api_id',
        'response'
    ];

    public function api()
    {
        return $this->belongsTo(API::class);
    }
}
