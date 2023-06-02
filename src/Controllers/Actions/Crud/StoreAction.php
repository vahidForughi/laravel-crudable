<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use function Generaltools\Crudable\Actions\Crud\request;

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
