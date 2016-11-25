<?php

namespace Positron\Foundation\Traits;

trait PositronFilterTrait
{

    protected $filters = [];

    public function getFilter($filterId)
    {
        if(isset($this->filters[$filterId]))
            return $this->filters[$filterId];
        return null;
    }

    public function addFilter($filterId, callable $cb, $priority = 0)
    {
        if(!isset($this->filters[$filterId])){
            $this->filters[$filterId] = [ "callbacks" => []];
        }
        array_push($this->filters[$filterId]["callbacks"], [
            "callback" => $cb, 
            "priority" => $priority
            ]);
    }
    public function getFilterCallbacks($filterId, $withPriority = true)
    {
        $filter = $this->getFilter($filterId);
        return $filter === null ? [] : 
            array_pluck( array_sort($filter["callbacks"], function ($item) {
                return $item['priority'];
            }),"callback");
    }
    public function doFilter($filterId, $payload = [])
    {   

        foreach ($this->getFilterCallbacks($filterId) as $cb) {
            $payload = call_user_func($cb, $payload);
        }
        return $payload;
    }

}