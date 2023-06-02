<?php

namespace Generaltools\Crudable\Classes;

use Generaltools\Crudable\Classes\Action\HasAction;
use Generaltools\Crudable\Classes\Chain\HasChain;
use Generaltools\Crudable\Classes\Config\Config;
use Generaltools\Crudable\Classes\Controller\HasController;
use Generaltools\Crudable\Classes\Entity\HasEntities;
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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class Crudable
{
    use
        HasQuery,
        HasEntities,
        HasController,
        HasChain,
        HasAction
        ;

    static private $config;

    protected $response = [];



    protected array $actions = [
        'index' => IndexAction::class,
        'store' => StoreAction::class,
        'show' => ShowAction::class,
        'update' => UpdateAction::class,
        'destroy' => DestroyAction::class
    ];


    protected array $handlers = [
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

        $this->initPolicies();

        $this->initQuery();

        $this->initController('crudable', $this->action);

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


    private function initConfig()
    {
        self::$config = new Config;
    }


    private function initPolicies()
    {
        foreach (self::config()->entitiesKeys() as $entity) {
            Gate::define($entity.'update-post', function () {
                return request()->user()->hasPermission();
            });
        }
    }



    private function globalBinds($action): void
    {
        $this->crudBinds($action);
    }


    private function crudBinds() {
        foreach($this->getHandlers() as $operation)
        {
            $this->bind('before-'.$operation, function () use ($operation) { $this->action->{'before' . ucwords($operation)}(); });
            $this->bind($operation, function () use ($operation) { $this->action->{$operation}(); });
            $this->bind('after-'.$operation, function () use ($operation) { $this->action->{'after' . ucwords($operation)}(); });
        }
    }

//
//    function do($action)
//    {
//        return app()->call($action, EntityController::class);
//    }


    function __call($func_name, $args)
    {
        /* this section create function name such as [ 'authorize' => 'makeAthorize', 'validate' => 'makeValidate' , ...] */
        $handlersFuncNames = [];
        foreach(array_keys($this->handlers) as $handler_key)
            $handlersFuncNames[$handler_key] = $this->getHandlerFuncName($handler_key);

        if (in_array($func_name, $handlersFuncNames))
            return $this->make(array_search ($func_name, $handlersFuncNames));

        return null;
    }


    function resources()
    {
        return $this->resources;
    }


    function getHandlers()
    {
        return array_keys($this->handlers);
    }


    function getActions()
    {
        return array_keys($this->actions);
    }


    function getHandlerFuncName($name): string
    {
        return 'make'.ucwords($name);
    }


    function response()
    {
        return $this->response;
    }

    function setResponse($response)
    {
        $this->response = $response;
    }

    function setResources($resources)
    {
        $this->resources = $resources;
    }

    static function config()
    {
        return self::$config;
    }
}
