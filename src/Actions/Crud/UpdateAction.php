<?php

namespace Generaltools\Crudable\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Generaltools\Crudable\Models\article;
use App\Models\User;

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
