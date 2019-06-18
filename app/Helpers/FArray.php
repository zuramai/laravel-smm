<?php 

namespace App\Helpers;

class FArray {
    public static function array_diff_key_recursive($a1, $a2)
    {
        $r = array();

        foreach ($a1 as $k => $v) {
            if (is_array($v)) {
                if (!isset($a2[$k]) || !is_array($a2[$k])) {
                    $r[$k] = $a1[$k];
                } else {
                    if ($diff = array_diff_key_recursive($a1[$k], $a2[$k])) {
                        $r[$k] = $diff;
                    }
                }
            } else {                                                            
                if (!isset($a2[$k]) || is_array($a2[$k])) {
                    $r[$k] = $v;
                }
            }
        }

        return $r;
    }

    public static function array_cast_recursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::array_cast_recursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = self::array_cast_recursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return self::array_cast_recursive((array)$array);
        }
        return $array;
    }
}


 ?>