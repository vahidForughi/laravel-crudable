<?php

namespace Generaltools\Crudable\Utils;

class Convertor
{

    static function arrayToBladeString(array $array) : string
    {
        return implode(', ', array_map(function ($value) { return "'".$value."'"; }, $array));
    }

}
