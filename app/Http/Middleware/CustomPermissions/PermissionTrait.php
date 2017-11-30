<?php

namespace App\Http\Middleware\CustomPermissions;

use App\Application\Model\Group;
use App\Application\Model\Role;


trait PermissionTrait{

    public $permission = [];

    protected function getUserPermissions($user , $type){
        $permissions = $user->with(['permission' => function ($query) use  ($type) {
            return  $query->where('controller_type' , $type);
        }])->first();
        if($permissions->permission){
            $this->conCanteToPermission($permissions->permission);
        }
    }
    protected function getGroupPermissions($user , $type){
        $permissions = Group::where('id' , $user->group_id)->with(['permission' => function ($query) use  ($type) {
            return  $query->where('controller_type' , $type);
        }])->first();
//        dd($type , $user , $permissions);
        if($permissions->permission){
            $this->conCanteToPermission($permissions->permission);
        }
    }
    protected function getUserRoles($user , $type){
        $roles = $user->with(['role.permission' => function($query) use ($type){
            return $query->where('controller_type' , $type);
        }])->first();
        if($roles->role){
            foreach($roles->role as $role){
                if($role->permission){
                    $this->conCanteToPermission($role->permission);
                }
            }
        }
    }
    protected function getGroupRoles($user , $type){
        $roles = Group::where('id' , $user->group_id)->with(['role.permission' => function($query) use ($type){
            return $query->where('controller_type' , $type);
        }])->first();
        if($roles->role){
            foreach($roles->role as $role){
                if($role->permission){
                    $this->conCanteToPermission($role->permission);
                }
            }
        }
    }

    public function can($user , $type = 'admin'){
         $this->getGroupRoles($user  , $type);
         $this->getGroupPermissions($user , $type);
         $this->getUserRoles($user , $type);
         $this->getUserPermissions($user , $type);
    }

    protected function conCanteToPermission($permissions){
        if(count($permissions) > 0){
            foreach($permissions as $r){
                $this->permission[$r->namespace][$r->method_name] = $r->permission;
            }
        }
    }


}