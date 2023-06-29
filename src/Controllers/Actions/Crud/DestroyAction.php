<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;

class DestroyAction extends Action implements ActionInterface
{

    public function query()
    {
//        Crudable::setQuery(Crudable::model()->where(Crudable::model()->getKeyName(), Crudable::modelId()));
    }

    public function action()
    {
        Crudable::query()->firstOrFail()->delete();
    }

    public function response()
    {
        Crudable::setResponse(true);
    }

}
