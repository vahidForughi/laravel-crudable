<?php

namespace Generaltools\Crudable\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;

class StoreAction extends Action implements ActionInterface
{


    public function query()
    {

    }


    public function action()
    {
        Crudable::setResponse(Crudable::query()->create(request()->all()));
    }


    public function response()
    {
        Crudable::setResponse([ "id" => Crudable::response()->id ]);
    }

}
