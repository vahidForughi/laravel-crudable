<?php

namespace Generaltools\Crudable\Classes;

use Generaltools\Crudable\Classes\Config\traits\HasConfig;
use Generaltools\Crudable\Classes\Action\traits\HasAction;
use Generaltools\Crudable\Classes\Chain\traits\HasChain;
use Generaltools\Crudable\Classes\Controller\traits\HasController;
use Generaltools\Crudable\Classes\Entity\traits\HasEntities;
use Generaltools\Crudable\Classes\Entity\traits\HasQuery;
use Generaltools\Crudable\Classes\Entity\traits\HasPolicies;
use Generaltools\Crudable\Classes\Response\traits\HasResponse;
use Generaltools\Crudable\Controllers\Actions\Crud\DestroyAction;
use Generaltools\Crudable\Controllers\Actions\Crud\IndexAction;
use Generaltools\Crudable\Controllers\Actions\Crud\ShowAction;
use Generaltools\Crudable\Controllers\Actions\Crud\StoreAction;
use Generaltools\Crudable\Controllers\Actions\Crud\UpdateAction;
use Generaltools\Crudable\Controllers\Handlers\Crud\ActionHandler;
use Generaltools\Crudable\Controllers\Handlers\Crud\AuthorizeHandler;
use Generaltools\Crudable\Controllers\Handlers\Crud\ModelHandler;
use Generaltools\Crudable\Controllers\Handlers\Crud\QueryHandler;
use Generaltools\Crudable\Controllers\Handlers\Crud\ResponseHandler;
use Generaltools\Crudable\Controllers\Handlers\Crud\ValidateHandler;
use Illuminate\Support\Str;

class Crudable
{
    use HasConfig,
        HasEntities,
        HasQuery,
        HasPolicies,
        HasController,
        HasChain,
        HasAction,
        HasResponse;


    private array $actions = [
        'index' => IndexAction::class,
        'store' => StoreAction::class,
        'show' => ShowAction::class,
        'update' => UpdateAction::class,
        'destroy' => DestroyAction::class
    ];


    private array $handlers = [
        'authorize' => AuthorizeHandler::class,
        'validate' => ValidateHandler::class,
        'model' => ModelHandler::class,
        'query' => QueryHandler::class,
        'action' => ActionHandler::class,
        'response' => ResponseHandler::class
    ];


    function init(): void
    {
        $this->parseResourcesAndActionFromRoute();

        $this->initConfig();

        // $this->initPolicies();

        $this->initQuery();

        $this->initController('crudable');

        $this->setChain($this->handlers);
    }


    private function parseResourcesAndActionFromRoute()
    {
        $routeNames = explode('.',request()->route()->getName());
        $action = end($routeNames);
        $resources = [];

        foreach (array_slice($routeNames, 0, count($routeNames) - 1 ) as $routeName)
            $resources[$routeName] = request()->route()->parameter(Str::singular($routeName));
            
        $this->setAction(new ($this->actions[$action])($action));
        $this->setResources($resources);
    }


    private function globalBinds(): void
    {
        $this->crudBinds();
    }


    private function crudBinds() {
        foreach($this->handlers() as $operation)
        {
            $this->bind('before-'.$operation, function () use ($operation) { $this->action->{'before' . ucwords($operation)}(); });
            $this->bind($operation, function () use ($operation) { $this->action->{$operation}(); });
            $this->bind('after-'.$operation, function () use ($operation) { $this->action->{'after' . ucwords($operation)}(); });
        }
    }


//    function do($action)
//    {
//        return app()->call($action, EntityController::class);
//    }


    function __call($func_name, $args)
    {
        /* this section create array of function names such as [ 'authorize' => 'makeAthorize', 'validate' => 'makeValidate' , ...] */
        $handlersFuncNames = [];
        foreach(array_keys($this->handlers) as $handler_key)
            $handlersFuncNames[$handler_key] = $this->getHandlerFuncName($handler_key);

        if (in_array($func_name, $handlersFuncNames))
            return $this->make(array_search ($func_name, $handlersFuncNames));

        return null;
    }


    public function getHandlerFuncName($name): string
    {
        return 'make'.ucwords($name);
    }


    public function handlers()
    {
        return array_keys($this->handlers);
    }


    public function actions()
    {
        return array_keys($this->actions);
    }

}
