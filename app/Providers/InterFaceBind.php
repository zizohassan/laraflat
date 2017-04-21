<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterFaceBind extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Application\Repository\InterFaces\UserInterface',
            'App\Application\Repository\Eloquent\UserEloquent'
        );
        $this->app->bind(
            'App\Application\Repository\InterFaces\GroupInterface',
            'App\Application\Repository\Eloquent\GroupEloquent'
        );
        $this->app->bind(
            'App\Application\Repository\InterFaces\RolesInterface',
            'App\Application\Repository\Eloquent\RolesEloquent'
        );
        $this->app->bind(
            'App\Application\Repository\InterFaces\HomeInterface',
            'App\Application\Repository\Eloquent\HomeEloquent'
        );
    }
}
