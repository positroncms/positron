<?php
namespace Positron\Providers;

use Positron;
use Illuminate\Support\ServiceProvider;
use Router;
use Module;
use Illuminate\Support\Facades\Route;
use Config;
use ReflectionClass;
use Positron\Foundation\Traits\Providers\ModuleTrait;
use Menu;
abstract class ModuleServiceProvider extends ServiceProvider
{

    use ModuleTrait;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerViewComposers();
        $this->registerMenus();

        $this->customBoot();


    }
    public function registerViewComposers() {}
    public function registerAdminMenu($menu) {}
    public function registerSettignsMenu($menu) {}

    public function customBoot() {}
    public function customRegister() {}


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->customRegister();
    }
    public function getPath( $path = '')
    {
        return $this->getModule()->getPath() . $path;
    }
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configPath = $this->getPath('/Config/config.php');

        $this->publishes([$configPath => config_path('positron.module.' . $this->getModuleSlug() . '.php')]);
        $this->mergeConfigFrom( $configPath, $this->getModuleSlug());
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/' . $this->getModuleSlug());

        $sourcePath = $this->getPath('/Resources/views');

        $this->publishes([ $sourcePath => $viewPath]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {

            return $path . '/modules/' . $this->getModuleName();
        }, \Config::get('view.paths')), [$sourcePath]), $this->getModuleSlug());
    }
    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/' . $this->getModuleSlug());

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->getModuleSlug());
        } else {
            $this->loadTranslationsFrom( $this->getPath('/Resources/lang'), $this->getModuleSlug());
        }
    }
    public function initPositronRoutes() 
    {
        Positron::registerRoutes('api',function(){
            Route::get('/modules', 'PackageController@moduleIndex');
        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    private function registerMenus() 
    {
        $this->app->booted(function () {
            if(Menu::get("admin"))
                $this->registerAdminMenu(Menu::get("admin"));
            else {
                Menu::make("admin",function($m){ 
                    $this->registerAdminMenu($m);
                });          
            }

        });
    }
}
