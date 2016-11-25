<?php

namespace Positron\Foundation\Traits;

trait PositronCrudReposTrait
{


    public function getCrudRepos()
    {

        return $this->doFilter('get-crud-repos');
    }

    public function registerCrudRepo(callable $cb)
    {        
        $this->addFilter('get-crud-repos', $cb);
    }

}