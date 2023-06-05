<?php

namespace Generaltools\Crudable\Classes\Entity\Route;


class Route
{
    public $name;
    public $permissions;
    public $rules;
    public $authorize;

    function __construct($name, $schema) {
        $this->name = $name;
        $this->parseSchema($schema);
    }

    private function parseSchema($schema) {
        foreach ($schema as $key => $value) {
            $this->{$key} = $value;
        }
    }
}


/**
 * @property string
 * @property array
 */
interface RouteTypeInterface {
}

class IndexRoute implements RouteTypeInterface {
}

class StoreRoute implements RouteTypeInterface {
}

class ShowRoute implements RouteTypeInterface {
}

class UpdateRoute implements RouteTypeInterface {
}

class DestroyRoute implements RouteTypeInterface {
}

