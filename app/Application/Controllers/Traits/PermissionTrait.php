<?php

namespace App\Application\Controllers\Traits;

trait PermissionTrait {

    protected function saveRolePermission($array , $item = null ,  $id = null){
        $addPermission = $item != null ? $item  : $this->model->find($id);
        if(method_exists( $this->model ,'role') && class_basename($this->model) != 'Permission'){
            $roles = array_has($array , 'roles') ?  $array['roles'] : [];
            $this->saveRoles($roles , $addPermission);
        }
        if(method_exists( $this->model ,'permission')) {
            $permission = array_has($array , 'permission') ?  $array['permission'] : [];
            $this->savePermission($permission, $addPermission);
        }
    }

    public function saveRoles($array , $item){
        if(count($array) > 0){
            $request = $this->checkIfArray($array);
            return $item->role()->sync($request);
        }
        return $item->role()->sync([]);
    }

    public function savePermission($array , $item){
        if(count($array) > 0){
            $request = $this->checkIfArray($array);
            return $item->permission()->sync($request);
        }
        return $item->permission()->sync([]);
    }

}