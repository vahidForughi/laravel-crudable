<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Classes\Entity\Relation\Relation;
use Generaltools\Crudable\Facades\Crudable;

class UpdateAction extends Action implements ActionInterface
{

    public function query()
    {

    }

    public function action()
    {
        $record = Crudable::query()->firstOrFail();
        $record->update(request()->all());

        $modelName = explode("\\", get_class($record));
        $entity = Crudable::entity(end($modelName));

        foreach ($entity->relations as $relation) {
            if (request()->has($relation->name))
                $record->saveRelated($relation, request()->input($relation->name));
        }


//        Crudable::setResponse($record);
    }

    public function response()
    {
        Crudable::setResponse(true);
    }

}
