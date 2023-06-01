<?php

namespace Generaltools\Crudable\Utils;

class Convertor
{

    static function arrayToBladeString(array $array) : string
    {
//        dd($array);
//        dd(array_values($array));
//        dd(implode(',', $array));
//        dd(implode(',',$array));
//        dd(111);
//        dd(array_map(function ($value) {
//            if (is_array($value)) {
//                return $value;
//            }else{
//                return $value;
//            }
//        }, $array));
        return implode(', ', array_map(function ($value) { return "'".$value."'"; }, $array));
    }

}
