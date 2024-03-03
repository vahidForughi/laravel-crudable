<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Classes\Entity\Relation\Relation;
use Generaltools\Crudable\Facades\Crudable;

class StoreAction extends Action implements ActionInterface
{


    public function query()
    {

    }


    public function action()
    {
        $record = Crudable::query()->create(request()->all());

        $modelName = explode("\\", get_class($record));
        $entity = Crudable::entity(end($modelName));

        foreach ($entity->relations as $relation) {

            if (request()->has($relation->name)) {
                $record->saveRelated($relation, request()->input($relation->name));
//                if ($relation->save_method == Relation::ASSOCIATED_SAVE_METHOD) {
//                    $model = Crudable::loadModel($relation->name)->find(request()->input($relation->name));
//                    $record->{$relation->name}()->associate($model);
//                    $record->save();
//                }
//                else if ($relation->method_name == Relation::SAVEMANY_SAVE_METHOD) {
//                    $models = array_map(fn ($value) => Crudable::loadModel($relation->name)->find($value), request()->input($relation->name));
//                    $record->{$relation->name}()->saveMany($models);
//                }
//                else if ($relation->method_name == Relation::SYNC_SAVE_METHOD)
//                    $record->{$relation->name}()->sync(request()->input($relation->name));
//                else
//                    $record->{$relation->name}()->sync(request()->input($relation->name));
            }
        }

        Crudable::setResponse($record);
    }


    public function response()
    {
        Crudable::setResponse([ "id" => Crudable::response()->id ]);
    }

}
