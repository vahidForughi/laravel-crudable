<?php

namespace Generaltools\Crudable\Classes\Action;

use Generaltools\Crudable\Classes\Action\ActionInterface;

trait HasAction
{
    protected ActionInterface $action;

    private array $actions = [];


    function action()
    {
        return $this->action;
    }


    public function setAction(ActionInterface $action)
    {
        $this->action = $action;
    }

    
    function actions()
    {
        return array_keys($this->actions);
    }

}
