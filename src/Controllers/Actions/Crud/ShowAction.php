<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;

class ShowAction extends Action implements ActionInterface
{

    public function query()
    {
        if (isset(request()->with))
            Crudable::setQuery(Crudable::query()->with(request()->with));
    }


    public function action()
    {
        Crudable::setResponse(Crudable::query()->firstOrFail());
    }

}
