<?php
$this->app->bind(
   'App\Application\Repository\InterFaces\ZizoInterface',
   'App\Application\Repository\Eloquent\ZizoEloquent'
);
