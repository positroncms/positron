<?php

namespace Positron\Foundation\Traits;

trait PositronActionTrait
{

    protected $actions = [];

    public function getAction($actionId)
    {
        if(isset($this->actions[$actionId]))
            return $this->actions[$actionId];
        return null;
    }

    public function listenAction($actionId, callable $cb, $priority = 0)
    {
        if(!isset($this->actions[$actionId])){
            $this->actions[$actionId] = [ "callbacks" => []];
        }
        array_push($this->actions[$actionId]["callbacks"], [
            "callback" => $cb, 
            "priority" => $priority
            ]);        
    }
    public function getActionCallbacks($actionId, $withPriority = true)
    {
        $action = $this->getAction($actionId);
        return $action === null ? [] : 
            array_pluck( array_sort($action["callbacks"], function ($item) {
                return $item['priority'];
            }),"callback");
    }
    public function doAction($actionId, $payload = [])
    {
        foreach ($this->getActionCallbacks($actionId) as $cb) {
            call_user_func($cb, $payload);
        }
    }

}