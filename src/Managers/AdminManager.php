<?php

namespace Positron\Managers;

use Countable;
use Illuminate\Foundation\Application;
use Positron\Foundation\Traits\PositronFilterTrait;
use Positron\Foundation\Traits\PositronRoutesTrait;
use Positron\Foundation\Traits\PositronActionTrait;
use Positron\Foundation\Traits\PositronEventTrait;


class AdminManager 
{
	use PositronFilterTrait, PositronRoutesTrait, PositronActionTrait, PositronEventTrait;
    /**
     * Application instance.
     *
     * @var Application
     */
    protected $app;
    protected $namespace = "positron.admin";

	public function __construct(Application $app)
    {
        $this->app = $app;        
    }


    public function registerDashboard()
    {
        
    }

}