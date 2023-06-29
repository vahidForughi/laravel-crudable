<?php

namespace Generaltools\Crudable\Routing;

use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router as BaseRouter;
use Generaltools\Crudable\Controllers\EntityController;

class Router
{

    static public function apiCruds(array $resources, array $options = [])
    {
        foreach ($resources as $name => $controller) {
            if (is_numeric($name)) {
                $name = $controller;
                $controller = null;
            }
            Route::apiCrud($name, $controller, $options);
        }
    }

    static public function apiCrud(string $name, null|string $controller = EntityController::class , array $options = [])
    {
//        dd(ResourceRegistrar::getResourceUri($name));
        $controller = $controller ?: EntityController::class;
        if ($controller == EntityController::class) {
            Route::namespace("\\")->group(function () use ($name, $controller, $options) {

                Route::apiResource($name, $controller, $options);

                if (str_contains($name, '.')) {
                    $uri = (new ResourceRegistrar(app()['router']))->getResourceUri($name);
                    Route::put($uri, [$controller, 'attach'], $options)->name($name.'.attach');
                }

            });
        }
        else
            Route::apiResource($name, $controller, $options);
    }

}
