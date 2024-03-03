<?php

namespace Generaltools\Crudable\Utils;

class Convertor
{

    static function arrayToBladeString(array $array) : string
    {
        return implode(', ', array_map(function ($value) {
            if (!$value)
                return 'null';
            else
                return "'".$value."'";
        }, $array));
    }


    static function addonMerge(...$parameters) {
//        return array_merge_recursive(...array_values($parameters));
        $merged = [];
        foreach ($parameters as $index => $array) {
            foreach ($array as $key => $value) {
                if (isset($merged[$key]) && is_array($merged[$key]) && is_array($value))
                    $merged[$key] = self::addonMerge($merged[$key], $value);
                else if (isset($merged[$key]) && array_is_list($array)) {
                    $merged = array_merge_recursive($merged, [$value]);
                }
                else
                    $merged[$key] = $value;
            }
        }
        return $merged;
    }

}
