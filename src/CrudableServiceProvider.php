<?php

namespace Generaltools\Crudable;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Response;
use \Generaltools\Crudable\Utils\Response as ResponseUtils;
use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Routing\Router;
use Generaltools\Crudable\Exceptions\Handler;
// use Illuminate\Support\Facades\Blade;
// use Illuminate\Support\Facades\View;
// use Generaltools\Crudable\Classes\Config;

class CrudableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/crudable.php' => config_path('crudable.php'),
                __DIR__.'/config/entities.php' => config_path('entities.php'),
            ], 'crudable-config');
        }

        $this->loadViewsFrom(__DIR__.'/Stubs', 'crudable.stubs');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->mergeConfigFrom(__DIR__.'/config/crudable.php', 'crudable');

        $this->app->singleton(ExceptionHandler::class, Handler::class);

        $this->app->singleton(Crudable::class, function () {
            $crudable = new Crudable;
            $crudable->init();
            return $crudable;
        });

        $this->app->singleton(Router::class, function () {
            return new Router;
        });


        Response::macro('jsonCrudable', function ($value) {
            return ResponseUtils::success($value);
        });
    }
}
