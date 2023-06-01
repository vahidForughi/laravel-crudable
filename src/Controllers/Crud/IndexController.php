<?php

namespace Generaltools\Crudable\Controllers\Crud;

use Generaltools\Crudable\Utils\Response;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Support\Str;

class IndexController extends ActionController
{

    static public function query()
    {
        if (isset(request()->with))
            Crudable::setModel(Crudable::model()->with(request()->with));

        foreach (request()->all() as $param => $value) {
            if (in_array($param, Crudable::model()->getFillable()))
                Crudable::setModel(Crudable::model()->{Str::camel('where_'.$param)}($value));
        }
    }


    static public function action()
    {
        $params = request()->all();
        $res = (isset($params['paginate']) && !!$params['paginate'])
            ? Crudable::model()->paginate(isset($params['limit'])?$params['limit']:null)
            : Crudable::model()->get();
        Crudable::setResponse($res);
    }


    static public function response()
    {

    }

}
