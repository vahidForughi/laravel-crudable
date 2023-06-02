<?php

namespace Generaltools\Crudable\Controllers;


use Generaltools\Crudable\Facades\Crudable;
use Generaltools\Crudable\Utils\Response;

class EntityController extends Controller
{

    function __construct()
    {
        Crudable::init();
        Crudable::handle([]);
//        Crudable::makeAuthorize();
//        Crudable::makeValidate();
//        Crudable::makeQuery();
//        Crudable::makeAction();
//        Crudable::makeResponse();
    }


    function __call($func_name, $args)
    {
        if (in_array($func_name, Crudable::getActions()))
            return Response::success(Crudable::response());

        return null;
    }

}
