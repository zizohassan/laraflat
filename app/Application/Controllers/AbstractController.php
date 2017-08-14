<?php

namespace App\Application\Controllers;

use App\Application\Controllers\Traits\ExceptionTrait;
use App\Application\Controllers\Traits\HelpersTrait;
use App\Application\Controllers\Traits\MainProcessTrait;
use App\Application\Controllers\Traits\ModelRelationTrait;
use App\Application\Controllers\Traits\PermissionTrait;
use App\Application\Controllers\Traits\UploadTrait;
use App\Application\Model\Log;
use App\Application\PermissionTraits\PermissionControl;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractController extends  Controller{

    use  PermissionTrait , UploadTrait , MainProcessTrait , HelpersTrait , ModelRelationTrait , ExceptionTrait;

    public $model;
    protected  $log;
    protected $related ;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->log = new Log();
    }

}