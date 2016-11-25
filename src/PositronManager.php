<?php

namespace Positron;

use Countable;
use Illuminate\Foundation\Application;

class PositronManager 
{
	use \Positron\Foundation\Traits\PositronFilterTrait, 
        \Positron\Foundation\Traits\PositronRoutesTrait, 
        \Positron\Foundation\Traits\PositronActionTrait, 
        \Positron\Foundation\Traits\PositronEventTrait,
        \Positron\Foundation\Traits\PositronCrudReposTrait;
    /**
     * Application instance.
     *
     * @var Application
     */
    protected $app;
    protected $namespace = "positron";

	public function __construct(Application $app)
    {
        $this->app = $app;        
    }



}