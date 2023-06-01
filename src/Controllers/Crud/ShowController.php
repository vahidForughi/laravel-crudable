<?php

namespace Generaltools\Crudable\Controllers\Crud;

use Generaltools\Crudable\Utils\Response;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Support\Str;

class ShowController extends ActionController
{


    public function crudShow()
    {
        if (isset(request()->with))
            $this->instance->load(request()->with);

        return Response::success($this->instance);
    }

    static public function model()
    {
        if (isset(request()->with))
            Crudable::$model->load(request()->with);
    }


    static public function action()
    {
        return Crudable::$model;
    }


    static public function response()
    {
        return Response::success(Crudable::$model);
    }

}
