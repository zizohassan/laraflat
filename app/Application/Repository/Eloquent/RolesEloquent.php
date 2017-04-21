<?php
namespace App\Application\Repository\Eloquent;

use App\Application\Model\Group;
use App\Application\Model\Permission;
use App\Application\Model\Role;
use App\Application\Repository\InterFaces\RolesInterface;


class RolesEloquent extends AbstractEloquent implements RolesInterface{

    public function __construct(Role $role)
    {
        $this->model = $role;
    }


    public function getPermissionById($id){
        return $this->model->where('id' , $id)->with('permission')->first();
    }

    public function getAllPermissions(){
        return Permission::pluck('name' , 'id')->all();
    }


}