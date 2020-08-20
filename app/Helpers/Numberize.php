<?php 

namespace App\Helpers;

class Numberize {
    public static function make($number)
    {
        if(substr(number_format($number,2),-2) == 00) {
        	return number_format($number,0,',','.');
        }else{
        	return number_format($number,2,',','.');
        }
    }
}


 ?>