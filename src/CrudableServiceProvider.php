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
use Illuminate\Routing\Router as BaseRouter;

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

//        $router = new Router($this->app['events'], $this->app);
//        $this->app->singleton('router', function ($app) use ($router) {
//            return $router;
//        });

//        $this->app->singleton(Router::class, function ($app) {
//            return new Router($app['events'], $app);
//        });

        BaseRouter::macro('apiCrud', fn (...$args) => Router::apiCrud(...$args));
        BaseRouter::macro('apiCruds', fn (...$args) => Router::apiCruds(...$args));


        Response::macro('jsonCrudable', function ($value) {
            return ResponseUtils::success($value);
        });
    }
}
