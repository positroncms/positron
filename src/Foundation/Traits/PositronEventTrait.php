<?php

namespace Positron\Foundation\Traits;

trait PositronEventTrait
{

    public function fireEvent($event, $data = null)
    {
        $this->app['events']->fire($this->namespace . "." . $event, $data);
        return $this;
    }

    public function addListener($event, callable $cb)
    {
        $this->app['events']->listen($event, $cb);        
        return $this;
    }

}