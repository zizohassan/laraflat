<?php
namespace  App\Application\Repository\Eloquent;

use App\Application\Model\Group;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractEloquent{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getNew($attribute = []){
        return $this->model->newInstance($attribute);
    }

    public function getAll(){
        return $this->model->get();
    }

    public function paginate($perpage = 30){
        return $this->model->paginate($perpage);
    }

    public function getById($id){
        return $this->model->FindOrFail($id);
    }

    public function delete($id){
        return $this->getById($id)->delete();
    }

    public function createOrUpdate($array , $id = null){
        if($id === null)
            return $this->createNew($array);
        return $this->updateExist($array , $id);
    }

    public function updateExist($array  , $id){
        $updateArray = $this->filterColumn($array);
        $item  = $this->getById($id);
        if($item){
            $item->update($updateArray);
            return $item;
        }
        return false;
    }

    public function createNew($array){
        $newArray = $this->filterColumn($array);
        return $this->model->create($newArray);
    }

    public function filterColumn($array){
        $newArray = [];
        foreach($this->getTableColumns() as $filed){
            if(key_exists($filed  , $array)){
                $newArray[$filed] = $array[$filed];
            }
        }
        return $newArray;
    }

    public function getTableColumns() {
        return $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
    }


    protected function checkIfArray($request){
        return is_array($request) ? $request : [$request];
    }

}