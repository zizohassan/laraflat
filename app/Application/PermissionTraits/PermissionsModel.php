<?php

namespace App\Application\PermissionTraits;

use App\Application\Model\Group;
use App\Application\Model\Role;


class PermissionsModel{
    protected function getUserPermissions($user){
        $permissions = $user->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->first();
        return $permissions->permission;
    }
    protected function getGroupPermissions($user){
        $permissions = Group::where('id' , $user->group_id)->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->first();
        return $permissions->permission;
    }
    protected function getUserRoles($user){
        $roles = $user->with('role')->first();
        $ids = $roles->role->pluck('id');
        $permissions = Role::whereIn('id' , $ids)->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->get();
        return $permissions;
    }
    protected function getGroupRoles($user){
        $roles = Group::where('id' , $user->group_id)->with('role.permission')->first();
        return $roles;
    }


    public function can($user){
        $groupRoles = $this->getGroupRoles($user);
        dd($groupRoles);
    }

}