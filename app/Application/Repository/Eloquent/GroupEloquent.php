<?php
namespace App\Application\Repository\Eloquent;

use App\Application\Model\Group;
use App\Application\Model\Permission;
use App\Application\Model\Role;
use App\Application\Repository\InterFaces\GroupInterface;


class GroupEloquent extends AbstractEloquent implements GroupInterface{

    public function __construct(Group $group)
    {
        $this->model = $group;
    }


    public function getPermissionById($id){
        return $this->model->where('id' , $id)->with('permission' , 'role')->first();
    }


}