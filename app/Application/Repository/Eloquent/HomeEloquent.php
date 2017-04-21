<?php
namespace App\Application\Repository\Eloquent;

use App\Application\Model\Group;
use App\Application\Model\Permission;
use App\Application\Model\Role;
use App\Application\Model\User;
use App\Application\Repository\InterFaces\HomeInterface;



class HomeEloquent extends AbstractEloquent implements HomeInterface{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getData(){
        $lastRegisterUser= $this->model->with('group')->limit(10)->orderBy('id' , 'desc')->get();
        return [
            'userCount' => $this->model->count(),
            'groupCount' => Group::count(),
            'permissionsCount' => Permission::count(),
            'roleCount' => Role::count(),
            'lastRegisterUser' => $lastRegisterUser
        ];
    }



}