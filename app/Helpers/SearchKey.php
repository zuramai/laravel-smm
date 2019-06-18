<?php 

namespace App\Helpers;

class SearchKey {
    public static function arraySearch($array, $search)
    {
    	foreach($array as $key=>$val){
			if($key===$search){
				return $val;
			}else if(is_array($val)){
				return self::arraySearch($val, $search);
			}
		}
    }
}


 ?>