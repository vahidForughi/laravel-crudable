<?php

namespace Generaltools\Crudable\Classes\traits;


use Generaltools\Crudable\Classes\Controller\Controller;

trait HasController
{
    public Controller $controller;

    private function initController($name): void
    {
        $this->controller = Controller::getInstance($name);
        $this->controller->reset();
        $this->globalBinds();
    }

    private function globalBinds() {}

    public function controller(string $action = null)
    {
        if ($action)
            return $this->make($action);

        return $this->controller;
    }

    public function bind(string $action, \Closure $closure)
    {
        $this->controller->bind($action, $closure);
        return $this;
    }

    public function make(string $action)
    {
        return $this->controller->make($action);
    }
}
