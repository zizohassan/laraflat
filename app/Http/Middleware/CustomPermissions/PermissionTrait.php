<?php

namespace App\Http\Middleware\CustomPermissions;

trait PermissionTrait{
    protected function getAction($method , $array , $id){
        if(is_array($array)){
            if(count($array) > 1){
                if(($method == 'show' || $method == 'store') && $id === true){
                    return 'edit';
                }else if(($method == 'show' || $method == 'store')  && $id !== true){
                    return 'add';
                }
            }else{
                return $array[0];
            }
        }
        return false;
    }
    protected function getMethod($method , $id){
        $array  = $this->actionsWithMethods();
        if(array_key_exists($method , $array)){
            return $this->getAction($method , $array[$method] , $id);
        }
        return false;
    }
}


