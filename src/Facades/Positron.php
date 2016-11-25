<?php 
namespace Positron\Facades;

use Illuminate\Support\Facades\Facade;

class Positron extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'positron'; }

}