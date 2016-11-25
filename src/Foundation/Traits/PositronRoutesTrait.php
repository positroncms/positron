<?php

namespace Positron\Foundation\Traits;

trait PositronRoutesTrait
{


    public function initRoutes($_namespace = 'default')
    {

        $this->doAction('routes' . $_namespace);
    }

    public function registerRoutes($_namespace = '', callable $cb)
    {        
        $this->listenAction('routes.init', $cb);
    }

}