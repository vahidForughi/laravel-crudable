<?php

namespace Generaltools\Crudable\Routing;

use Generaltools\Crudable\Facades\Crudable;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Support\Facades\Route;
use Generaltools\Crudable\Controllers\EntityController;

class Router extends Route
{

    public function apiCruds(array $resources, array $options = [])
    {
        foreach ($resources as $name => $controller) {
            $this->apiCrud($name, $controller, $options);
        }
    }

    public function apiCrud(string $name, string $controller = EntityController::class , array $options = [])
    {
        return Route::apiResource($name, $controller, $options);
    }

}
