<?php

namespace Generaltools\Crudable\Controllers;


use Generaltools\Crudable\Facades\Crudable;
use Generaltools\Crudable\Utils\Response;

class EntityController extends Controller
{

    function __construct()
    {
        Crudable::init();
        // $controller = Crudable::controller()->bind('after-action', function () {
        //     Crudable::setResponse('111111');
        // })
        // ->bind('after-action', function () {
        //     Crudable::setResponse('222222');
        // });

        // $controller->bind('after-action', function () {
        //     Crudable::setResponse('333333');
        // });
        
        //    Crudable::bind('response', function () {
        //         Crudable::setResponse('444444');
        //    });
        

        // Crudable::makeAuthorize();
        // Crudable::makeValidate();
        // Crudable::makeQuery();
        // Crudable::makeAction();
        // Crudable::makeResponse();        

        Crudable::handle([]);
    }


    function __call($func_name, $args)
    {
        if (in_array($func_name, Crudable::actions()))
            return Response::success(Crudable::response());

        return null;
    }

}
