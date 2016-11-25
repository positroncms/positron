<?php
namespace Positron\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Module;
use Config;
use Positron;
use LaravelLocalization;
use Illuminate\Support\Facades\Route;
use Positron\Foundation\Traits\Providers\ModuleTrait;

abstract class RouteServiceProvider extends ServiceProvider
{
    use ModuleTrait;
    protected $defered = false;
    
    public function registerWebRoutes() {}
    public function registerWebTranslatableRoutes() {}
    public function registerAdminRoutes() {}
    public function registerApiRoutes() {}
    public function registerRoutes(){}
    public function customBoot() {}
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->customBoot();
    }
    public function map()
    {
        $namespacePrefix = "Modules\\" . $this->getModuleName() . "\\Http\\Controllers";
        Route::group([
            'namespace' => $namespacePrefix
        ], function ($router) {
            $this->registerRoutes();
        });
        Route::group([
            'middleware' => ['web', 'theme.set:bootstrap'],
            'namespace' => $namespacePrefix . '\\Web'
        ], function ($router) {
            $this->registerWebRoutes($router);
        });
        Route::group([
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['web', 'theme.set:bootstrap', 'localize'],
            'namespace' => $namespacePrefix . '\\Web'
        ], function ($router) {
            $this->registerWebTranslatableRoutes($router);
        });


        

        Route::group([
//            'as' => $this->getModuleSlug() . '::',
            'middleware' => ['web', 'theme.set:lteadmin'],
            'prefix' => Config::get('positron.admin_prefix', 'admin') . '/' . $this->getModuleSlug() ,
            'namespace' => $namespacePrefix . '\\Admin'
        ], function ($router) {
            $this->registerAdminRoutes($router);
        });


        Route::group([
            'middleware' => 'api',
            'prefix' => Config::get('positron.api_prefix', 'api') ,
            'namespace' => $namespacePrefix . '\\Api'
        ], function ($router) {
            $this->registerApiRoutes($router);
        });
    }
}
