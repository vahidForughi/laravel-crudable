<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use App\Models\User;
use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Generaltools\Crudable\Models\article;

class UpdateAction extends Action implements ActionInterface
{

    public function query()
    {

    }

    public function action()
    {
        Crudable::query()->firstOrFail()->update(request()->all());
    }

    public function response()
    {
        Crudable::setResponse(true);
    }

}
