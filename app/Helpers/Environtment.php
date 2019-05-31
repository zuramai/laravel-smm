<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Artisan;

class Environtment {
    public static function setEnvironmentValue($key, $value)
    {
        Artisan::call("env:set $key $value");
    }
}


 ?>