<?php

namespace Generaltools\Crudable\Controllers\Handlers\Crud;


use Generaltools\Crudable\Classes\Chain\BaseHandler;
use Generaltools\Crudable\Facades\Crudable;

class Handler extends BaseHandler
{

    public function handle($request)
    {
        /* some else */
        //

        $handlerFuncName = Crudable::getHandlerFuncName($this->getName());
        Crudable::{$handlerFuncName}();

        parent::handle($request);
    }

}
