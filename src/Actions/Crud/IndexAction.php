<?php

namespace Generaltools\Crudable\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Support\Str;

class IndexAction extends Action implements ActionInterface
{

    public function query()
    {
        if (isset(request()->with))
            Crudable::setQuery(Crudable::query()->with(request()->with));

        foreach (request()->all() as $param => $value) {
            if (!in_array($param, ['with','page','paginate','limit','__randNum']))
                Crudable::setQuery(Crudable::query()->where($param,$value));
        }
    }


    public function action()
    {
        $params = request()->all();
        Crudable::setResponse(
            (isset($params['paginate']) && !!$params['paginate'])
            ? Crudable::query()->paginate(isset($params['limit'])?$params['limit']:null)
            : Crudable::query()->get()
        );
    }

}
