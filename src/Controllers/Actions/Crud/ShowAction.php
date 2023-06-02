<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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
