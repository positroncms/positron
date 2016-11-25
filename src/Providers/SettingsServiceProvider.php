<?php namespace App\Providers;

namespace Positron\Providers;

class SettingsServiceProvider extends ServiceProvider {
    protected $settingsCompiledPath = storage_path('/positron/core/compiled-settings.php');

    public function register()
    {
        config([
            'laravellocalization.supportedLocales' => [
//                'ace' => array( 'name' => 'Achinese', 'script' => 'Latn', 'native' => 'Aceh' ),
//                'ca'  => array( 'name' => 'Catalan', 'script' => 'Latn', 'native' => 'català' ),
                'en'  => array( 'name' => 'English', 'script' => 'Latn', 'native' => 'English' ),
                'sr'  => array( 'name' => 'Serbian', 'script' => 'Latn', 'native' => 'Srpski' ),
            ],

            'laravellocalization.useAcceptLanguageHeader' => true,

            'laravellocalization.hideDefaultLocaleInURL' => true
        ]);
    }
    private function loadSettingsFromCache() 
    {
        return (include $this->settingsCompiledPath);

    }
    private function hasCahce()
    {
        return file_exists($this->settingsCompiledPath);
    }

}