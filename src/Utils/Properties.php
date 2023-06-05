<?php

namespace Generaltools\Crudable\Utils;

use Illuminate\Support\Str;

class Properties
{

    static function setPropertiesFromArray($source ,array $values) {
        foreach ($values as $property => $value)
            $source->{$property} = $value;
    }


    static function setPropertyAsClassFromArray($source, $property, array $values, $class, \Closure $closure = null ) : void {
        $source->{$property} = [];
        foreach ($values as $name => $value) {
            $source->{$property}[] = new $class($name, $value);
            if ($closure)
                $closure($name, $value);
        }
    }

}
