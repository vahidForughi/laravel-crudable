<?php

namespace Generaltools\Crudable\Classes\Controller;


trait HasController
{
    protected Controller $controller;

    private function initController($name, $action): void
    {
        $this->controller = Controller::getInstance($name);
        $this->controller->reset();
        $this->globalBinds($action);
    }

    private function globalBinds($action) {}

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
