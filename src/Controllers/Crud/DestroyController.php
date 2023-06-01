<?php

namespace Generaltools\Crudable\Controllers\Crud;

use Generaltools\Crudable\Utils\Response;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Support\Str;

class DestroyController extends ActionController
{


    public function crudDestroy()
    {
        $this->instance->delete();
        return Response::success(true);
    }
    static public function model()
    {
        if (isset(request()->with))
            Crudable::$model = Crudable::$model->with(request()->with);

        foreach (request()->all() as $param => $value) {
            if (in_array($param, Crudable::$query->getFillable()))
                Crudable::$model = Crudable::$model->{Str::camel('where_'.$param)}($value);
        }
    }


    static public function action()
    {
        $params = request()->all();
        return (isset($params['paginate']) && !!$params['paginate']) ? Crudable::$model->paginate(isset($params['limit'])?$params['limit']:null) : Crudable::$model->get();;
    }


    static public function response()
    {
        return Response::success();
    }

}
