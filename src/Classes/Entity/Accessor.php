<?php

namespace Generaltools\Crudable\Classes\Entity;


class Accessor {

    public string $name;
    public $callback;


    function __construct($name, $callback) {
        $this->name = $name;
        $this->callback = $callback;
    }

    
    function call($value) {
        return ($this->callback)($value);
    }

}
