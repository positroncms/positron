<?php

namespace Positron;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Providers\BootstrapServiceProvider;
use Nwidart\Modules\Providers\ConsoleServiceProvider;
use Nwidart\Modules\Providers\ContractsServiceProvider;
use Nwidart\Modules\Repository as ModulesRepository;
use ReflectionFunction;

class PositronServiceProvider extends ServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Booting the package.
     */
    public function boot()
    {

        $this->initRoutes();
        $this->registerAliases();

    }    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerServices();

        //$this->registerProviders();
    }
    /**
     * Register the service provider.
     */
    protected function registerServices()
    {

        $this->app->singleton('positron', function ($app) {
            return new PositronManager($app);
        });
       
    }
    protected function registerAliases () 
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
    }
    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $configPath = __DIR__ . '/../config/config.php';
        $this->mergeConfigFrom($configPath, 'positron');
        $this->publishes([
            $configPath => config_path('positron.php'),
        ], 'config');

    }
    protected function initRoutes()
    {
                
        if (! $this->app->routesAreCached()) {
            $this->app['positron']->initRoutes();
            $this->app['positron']->initRoutes("frontend");
            $this->app['positron']->initRoutes("dashboards");
            $this->app['positron']->initRoutes("api");
        }
    }
    
   

    public function provides()
    {
        return ['positron'];
    }
}