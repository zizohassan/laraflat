<?php

namespace App\Application\PermissionTraits;

use App\Application\Model\Group;
use App\Application\Model\Permission;
use App\Application\Model\Role;
use App\Application\Model\User;
use Illuminate\Database\Eloquent\Model;

class PermissionsModel{
    protected function checkRolePermission($action , $roles , $model = null){
        $response = [];
        foreach($roles as $role){
            if($role->permission->count() > 1){
                $response = array_merge($response , $this->moreThanRole($action , $role->permission , $model)) ;
            }else{
                if(isset($role->permission->first()->model)){
                        $name = isset($role->permission->first()->model) ?  $role->permission->first()->model : $role->slug;
                        $response[$name] =  $this->checkPermissions($action , $role->permission , $model);
                }
            }
        }
        return empty($response) ? false : $response;
    }
    protected function moreThanRole($action , $roles , $model = null){
            $response = [];
            foreach($roles as $key => $role){
                    if(array_key_exists($role->model , $response)){
                        $index  = $role->model;
                    }else{
                        $index  = $role->model;
                    }
                    $response[$index] =  $this->checkPermissions($action , $role , $model , 'object');
            }
            return empty($response) ? false : $response;
    }
    protected function checkPermissions($action , $permissions , $model  ,  $type = 'array' , $role = false){
        if(count($permissions) == 0 && $type == 'array'){
            return false;
        }
        if($type == 'object' && isset($permissions->id)){
            $permissions = [$permissions];
        }
        $array = [];
        $action = $this->returnArray($action);
        $model = $this->returnArray($model);
        foreach($permissions as $permission){
            if(in_array($permission->model , $model)){
                if($role !== false){
                    $array[$permission->model]['actions'] = $this->checkAction($permission , $action);
                } else{
                    $array['actions'] = $this->checkAction($permission , $action);
                }
            }else{
                $array[$permission->model] = false;
            }
        }
        return count($array) == 0 ? false :  $array;
    }
    protected function checkAction($permission , $actions){
        $response = [];
        foreach($this->actionArray() as $action){
            if(in_array($action , $actions)){
                if($permission['action_'.$action] == 'on'){
                    $response[$action] = true;
                }else{
                    $response[$action] = false;
                }
            }else{
                if($permission['action_'.$action] == 'on'){
                    $response[$action] = true;
                }else{
                    $response[$action] = false;
                }
            }
        }
        return count($response) == 0 ? false  : $response;
    }
    protected function getUserPermissions($user , $model){
        $permissions = $user->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->first();
        return $permissions->permission;
    }
    protected function getGroupPermissions($user , $model){
        $permissions = Group::where('id' , $user->group_id)->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->first();
        return $permissions->permission;
    }
    protected function getUserRoles($user , $model){
        $roles = $user->with('role')->first();
        $ids = $roles->role->pluck('id');
        $permissions = Role::whereIn('id' , $ids)->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
        }])->get();
        return $permissions;
    }
    protected function getGroupRoles($user , $model){
        $roles = Group::where('id' , $user->group_id)->with('role')->first();
        $ids = $roles->role->pluck('id');
        $permissions = Role::whereIn('id' , $ids)->with(['permission' => function ($query) use  ($model) {
            return  $query->whereIn('model', $this->returnArray($model))->orderBy('id' , 'desc');
            }])->get();
        return $permissions;
    }
    protected function returnArray($array){
        return is_array($array) ? $array : [$array];
    }
    protected function actionArray(){
        return [
            'add' ,'edit' , 'view' , 'delete'
        ];
    }
    public function can($user , $action , $model){
        $checkGroupPermission = $this->checkPermissions($action , $this->getGroupPermissions($user , $model) , $model , 'object' , true);
        $checkUserPermission = $this->checkPermissions($action , $this->getUserPermissions($user , $model) , $model , 'object' , true);
        $checkGroupRoles = $this->checkRolePermission($action , $this->getGroupRoles($user , $model) , $model);
        $checkUserRoles = $this->checkRolePermission($action , $this->getUserRoles($user , $model) ,$model);
        return collect([
                $checkGroupRoles,
                $checkGroupPermission,
                $checkUserRoles,
                $checkUserPermission,
            ])->collapse()->all();
    }
    public function canUser($user , $action , $model){
        $per = $this->can($user , $action , $model);
        return isset($per[$model]['actions'][$action]) ? $per[$model]['actions'][$action] : false;
    }
}