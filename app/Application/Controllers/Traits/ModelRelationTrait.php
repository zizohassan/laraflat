<?php

namespace App\Application\Controllers\Traits;

trait ModelRelationTrait{


    public function saveRelationWithModel($relationName ,  $id , $request){
        $this->addRelationShip($relationName);
        if($this->related != null){
            return $this->addOrUpdateRelation($id , $request);
        }
    }


    public function addRelationShip($relation){
        if(method_exists($this->model, $relation)){
            $this->related  = $this->model->{$relation}();
            if($this->related instanceof HasMany){
                $this->getHasManyModel();
            }
        }
    }

    public function getHasManyModel(){
        return $this->related = $this->related->getQuery()->getModel();
    }

    public function addOrUpdateRelation($id = null , $request_array ){
        if($id == null){
            return $this->createRelation($request_array);
        }
        return $this->updateRelation($id , $request_array);
    }

    public function createRelation($request_array){
        try{
            return $this->related->create($request_array);
        }catch (\Exception $e){
            return $this->catchExceptions($e);
        }

    }

    public function updateRelation($id , $request_array){
        try{
            return $this->related->find($id)->update($request_array);
        }catch (\Exception $e){
            return $this->catchExceptions($e);
        }
    }


    protected function getRelationType($relation){
        return $this->model->getRelation($relation);
    }



}