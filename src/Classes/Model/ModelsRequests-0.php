<?php

namespace Generaltools\Crudable\Classes\Model;



use Generaltools\Crudable\Classes\Config;
use Generaltools\Crudable\Classes\Stub;
use Generaltools\Crudable\Models\EntityModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait ModelsRequests0
{

//    protected $module = '';
    public string $modelClass;
    public string $modelName;
    public array $relationsName = [];
    public $model;
    public $query;
    public $modelId = null;
    protected $relation;
    protected $relationId = null;
    protected $fields;
    protected $instance;


    public function bootModel()
    {
        $this->parseModel();
        $this->parseRelation();
        $this->getInstance();
    }


    private function parseModel($modelClass = null)
    {
        if ($modelClass)
            $this->setModelClass($modelClass);
        else {
            eval( Stub::getStub('EntityModel', [
                'EntityName' => $this->modelName,
                "EntityTable" => $this->entity->table,
                "EntityFillable" => $this->entity->fillable,
                "EntityGuarded" => $this->entity->guarded,
                "EntityHidden" => $this->entity->hidden,
                "EntityAppends" => $this->entity->appends,
                "EntityCasts" => $this->entity->casts
            ]));
            $this->setModelClass('\Generaltools\Crudable\Models\\'.$this->modelName);
        }
        $this->model = new ($this->getModelClass());
//        if (!$this->model)
//        {
//            if (!$this->modelClass)
//                $this->modelName = str_replace('Controller', '', class_basename($this));

//            $modelClassName = ($this->module ? 'Modules\\' . $this->module :  Config::getModelsPath()) . $this->modelName;
//            $this->model = new $modelClassName;
//            $this->model = new $this->modelClass();
//        }

    }


    private function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
    }


    private function getModelClass()
    {
        return $this->modelClass;
    }


    private function parseRelations()
    {
        if ($this->relation && !$this->relationId)
            $this->relationId = $this->getParam($this->model->{$this->relation}()->getRelated());
    }


    private function getData()
    {
//        if (!$this->modelId)
//            $this->modelId = $this->getParam($this->model);

        $this->instance = !$this->modelId ? $this->model : $this->model::findOrfail($this->modelId);
        if ($this->relation)
        {
            if ($this->relationId)
                $this->instance = $this->instance->{$this->relation}()->findOrfail($this->relationId);
            else
                $this->instance = $this->instance->{$this->relation}();
        }
    }

//
//    private function parseRequest()
//    {
//        $className = explode('\\',static::class);
//        $requestClass = 'App\\Http\\Requests\\'.explode('Controller',end($className))[0].'Request';
////        dd(new $requestClass());
////        app()->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
////            $resolved->validateResolved();
////        });
//
////        app()->resolving($requestClass, function ($request, $app) use($requestClass) {
//            $this->request = $requestClass::createFrom(request(), request());
//
////            $request->setContainer($app)->setRedirector($app->make(Redirector::class));
////        });
//
////        dd($this->request);
//        $this->request = $this->request->validate(request()->all());
//    }


    function modelId()
    {
        return $this->modelId ?? $this->parameter($this->modelName);
    }

    private function parameter($name)
    {
        return request()->route()->parameter($name);
    }


    function initModelProperties($source) {
        if ($source->table)
            $this->model->setTable($source->table);

//        $this->model->mergeFillable($source->fillable);
//        $this->model->guard($source->guarded);
//        $this->model->setHidden($source->hidden);
//        $this->model->mergeCasts($source->casts);
//        $this->model->setAppends($source->appends);

//        foreach(['hidden','casts','appends'] as $property => $value) {
//            $setFunc = 'set'.ucfirst($property);
//            $this->model->{$property}($source->{$value});
//        }
    }


    function initModelRelations($relations) {
        foreach ($relations as $relation) {
            // dd($relation);
            $this->model->resolveRelationUsing($relation->name, function ($model) use ($relation) {
                $result = $model->{$relation->method_name}(...$relation->method_args);
                if (!empty($relation->with))
                    $result = $result->with(...$relation->with);
                if (!empty($relation->withPivot))
                    $result = $result->withPivot(...$relation->withPivot);
                if ($relation->withTimestamps)
                    $result = $result->withTimestamps();
                return $result;
            });
        }
    }


    public function model()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function query()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

    function setModelName($modelName)
    {
        $this->modelName = Str::singular($modelName);
    }

    function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    function setRelationsName($relationsName)
    {
        $this->relationsName = $relationsName;
    }

}
