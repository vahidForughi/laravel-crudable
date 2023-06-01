<?php

namespace Generaltools\Crudable;

use Generaltools\Crudable\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Generaltools\Crudable\Classes\Crudable;
use Generaltools\Crudable\Classes\Config;
use Generaltools\Crudable\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

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

        $this->loadViewsFrom(__DIR__.'/Views', 'crudable');
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
            return new Crudable;
        });

        $this->app->singleton(Router::class, function () {
            return new Router;
        });
    }
}
