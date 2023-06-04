<?php

namespace Generaltools\Crudable\Classes\traits;

use Generaltools\Crudable\Classes\Action\ActionInterface;

trait HasAction
{
    protected ActionInterface $action;


    function action()
    {
        return $this->action;
    }


    public function setAction(ActionInterface $action)
    {
        $this->action = $action;
    }

}
