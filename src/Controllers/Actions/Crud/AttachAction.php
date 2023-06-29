<?php

namespace Generaltools\Crudable\Controllers\Actions\Crud;

use Generaltools\Crudable\Classes\Action\ActionInterface;
use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Validation\Rule;

class AttachAction extends Action implements ActionInterface
{

    const SAVE_TYPES = ['attach', 'detach', 'sync', 'syncWithoutDetaching', 'syncWithPivotValues'];

    public function afterValidate()
    {
        request()->validate([
            'save_type' => ['bail', 'string', 'required', Rule::in(self::SAVE_TYPES)],
        ]);
    }

    public function query()
    {

    }

    public function action()
    {
//        dd(Crudable::query()->syncWithoutDetaching([1,3]));
//        dd(Crudable::query()->syncWithPivotValues([1], ["color"=>"red"]));
//        dd(Crudable::query()->detach([2,3]));
//        dd(Crudable::query()->attach([1],["color" => "green"]));
//        Crudable::query()->firstOrFail()->update(request()->all());
        // TODO: sync with separate pivot for every input : sync([ 1 => ["pivot" => "blob"], 2 => ["pivot" => "blob"] , ... ])
        $resources = Crudable::resources();
        if (! empty($resources)) {
            $fillables = $this->getFillablePivotValues($resources);
            $operation = in_array(request()->input('save_type') , self::SAVE_TYPES) ? request()->input('save_type') : null;
            if ($operation) {
                $inputToOperate = request()->input(array_key_last(Crudable::resources()));
                if ($fillables && !empty ($fillables))
                    $result = Crudable::query()->{$operation}($inputToOperate, $fillables);
                else
                    $result = Crudable::query()->{$operation}($inputToOperate);
            }
            else
                throw new \InvalidArgumentException;

            Crudable::setResponse($result);
        }
        else
            throw new \InvalidArgumentException;

    }

//    public function response()
//    {
//        Crudable::setResponse(true);
//    }

    private function getFillablePivotValues($resources)
    {
        $entity = Crudable::entity(array_key_first(array_slice($resources, count($resources) - 2, 1, true)));
        $relation = array_filter($entity->relations,  fn ($relation) => $relation->name == array_key_last($resources));
        if (! empty($relation)) {
            $relation = array_values($relation)[0];
            $fillables = [];
            foreach ($relation->fillablePivot as $fillable) {
                if (request()->has($fillable))
                    $fillables[$fillable] = request()->input($fillable);
            }
            return $fillables;
        }
        else
            return [];
    }

}
