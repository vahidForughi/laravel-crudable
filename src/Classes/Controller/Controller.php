<?php

namespace Generaltools\Crudable\Classes\Controller;


use Generaltools\Crudable\Controllers\CrudController;
use Generaltools\Crudable\Controllers\EntityController;
use Generaltools\Crudable\Classes\Entity\Entity;
use Illuminate\Support\Facades\App;

class Controller
{
    private static array $instances = [];

    private string $name;


    private function __construct($name)
    {
        $this->name = $name;
    }


    public static function getInstance($name)
    {
        if (!isset(self::$instances[$name]))
            self::$instances[$name] = new self($name);

        return self::$instances[$name];
    }


    function reset()
    {
        app()->bind($this->getTag().'*', function() {});
    }

    
    function bind(string $action, \Closure $closure)
    {
        app()->bind($this->getTag($action), $closure);
        return $this;
    }


    function make(string $action)
    {
        app($this->getTag('before-'.$action));
        $result = app($this->getTag($action));
        app($this->getTag('after-'.$action));
        return $result;
    }


    public function getTag($name = null): string
    {
        return Crudable::class.'-controller-'.$this->name.'-'.($name?$name:'');
    }
}
