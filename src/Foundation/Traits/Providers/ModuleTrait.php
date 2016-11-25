<?php

namespace Positron\Foundation\Traits\Providers;
use ReflectionClass;
use Module;
trait ModuleTrait
{
    protected $module;

    public function getModuleName() 
    {        
        return $this->getModule()->name;
    }
    public function getModuleFile () 
    {
        $obj = new ReflectionClass($this);
        $filename = dirname(dirname($obj->getFileName())) . '/module.json'; 
        return $filename;
    }
    public function getModuleSettings () 
    {
        return json_decode(file_get_contents($this->getModuleFile()));
    }

    
    public function getModulePath () {

    }
    public function getModule()
    {
        if(!isset($this->module)){
           
            $settings = $this->getModuleSettings();

            $this->module = Module::get($settings->name);
        }
        return $this->module;
    }
    public function getModuleSlug() 
    {        
        return $this->getModule()->getLowerName();
    }

}