<?php

namespace Generaltools\Crudable\Classes;

class Stub
{

    static function getStub($type, array $replace = [])
    {
        return str_replace(
            array_map(function ($value) { return self::toVarFormat($value); }, array_keys($replace)),
            array_map(function ($value) { return is_array($value) ? json_encode($value) : $value; },array_values($replace)),
            file_get_contents(__dir__."\..\Stubs\\$type.stub")
        );
    }


    static function toVarFormat($var)
    {
        return '{{ ' . $var . ' }}';
    }


    static function getView($type, array $variables)
    {
        return view("crudable::$type", $variables)->render();
    }

}
