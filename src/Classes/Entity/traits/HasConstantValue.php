<?php

namespace Generaltools\Crudable\Classes\Entity\traits;


trait HasConstantValue
{

    static public function getAttributeName($value ,$prefix, $names)
    {
        $result = null;
        if ($value && $names && count($names) > 0) {
            foreach ($names as $name) {
                if (get_called_class()::getConstantValue($prefix, $name) == $value) {
                    $result = $name;
                    break;
                }
            }
        }
        return $result;
    }


    static public function getConstantValue($prefix, $name)
    {
        return $name ? constant(get_called_class().'::'.strtoupper($prefix.$name)) : null;
    }

}
