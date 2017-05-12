<?php

namespace App\Application\Controllers;

use App\Application\Model\Log;
use App\Application\Model\User;
use App\Application\PermissionTraits\PermissionControl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

abstract class AbstractController extends  Controller{

    public $model;
    protected  $log;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->log = new Log();
    }

    public function GetAll($view , $with = [] , $paginate = 30){
        $items = $this->model->with($with)->paginate($paginate);
        return view($view , compact('items'));
    }

    public function createOrEdit($view , $id = null , $data = ['']){
        if($id == null){
            $this->createLog('Visit Create Page' , 'Success');
            return view($view , compact('data'));
        }
        $dataLog = [
            'Edit Id' => [$id]
        ];
        $this->createLog('Visit Edit Page' , 'Success' , json_encode($dataLog));
        $item = $this->model->where('id' , $id)->first();
        return view($view , compact('item' , 'data'));
    }
    public function storeOrUpdate(Request $request , $id = null , $callback = true){
        $validation =  $this->itemValidation($request->all() , $id);
        if($validation !== true){
            return redirect()->back()->with(['errors' => $validation]);
        }
        $field = checkIfFiledFile($request->all());
        if($field){
            $request = $this->uploadFile($request , $field);
        }else{
            $request = $request->all();
        }
        if($id == null){
            return $this->storeItem($request , $callback);
        }
        $item =  $this->model->where('id' , $id)->first();
        return $this->updateItem($request , $item , $callback , $id);
    }

    public function itemValidation($array , $id){
        if($id == null){
            $valid = Validator::make($array,$this->model->validation($id));
        }else{
            $valid = Validator::make($array,$this->model->updateValidation($id));
        }
        if($valid->fails()){
            if($id != null){
                $this->createLog('Update' , 'Error' , json_encode($valid->errors()));
            }else{
                $this->createLog('Create' , 'Error' , json_encode($valid->errors()));
            }
            return $valid->errors();
        }
        return true;
    }
    public function storeItem($array  , $callback){
        $encodeArray = transformArray($array);
        $new = $this->model->create($encodeArray);
        if($this->model->getTable() != 'logs') {
            $dataLog = [
                'New id' => [$new->id]
            ];
            $this->createLog('Create', 'Success', json_encode($dataLog));
        }
        $this->saveRolePermission($array , $new);
        if($callback !== true){
            return redirect($callback);
        }
        return $new;
    }

    public function updateItem($array , $item , $callback , $id){
        $encodeArray = transformArray($array);
       $update = $item->update($encodeArray);
        if($this->model->getTable() != 'logs') {
            $dataLog = [
                'Updated id' => [$id]
            ];
            $this->createLog('Update', 'Success', json_encode($dataLog));
        }
        $this->saveRolePermission($array , null , $id);
        if($update){
            if($callback !== true){
                return redirect($callback);
            }
            return redirect()->back();
        }
        return redirect(404);
    }

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
    public function deleteItem($id , $callBack = null){
        $item = $this->model->find($id);
        $item = $item ? $item : null;
        if($item == null){
            if($this->model->getTable() != 'logs') {
                $dataLog = [
                    'Updated id' => [$id]
                ];
                $this->createLog('Delete', 'Error', json_encode($dataLog));
            }
            return redirect(404);
        }
        if($item->delete()){
           if($this->model->getTable() != 'logs'){
               $dataLog = [
                   'Updated id' => [$id]
               ];
               $this->createLog('Delete' , 'Success' , json_encode($dataLog));
           }
            if($callBack != null){
                return redirect($callBack);
            }
            return redirect()->back();
        }
        return redirect('404');
    }
    public function uploadFile($request , $field){
        if($request->file($field) != null){
            $destinationPath = env('UPLOAD_PATH');
            $all = [];
            $imageName = '';
            if(is_array($request->file($field))){
                foreach($request->file($field)  as $file){
                    $all[] = $this->uploadFileOrMultiUpload($file , $destinationPath);
                }
            }else{
               $imageName = $this->uploadFileOrMultiUpload($request->file($field) , $destinationPath);
            }
            $request = $request->except($field);
            if(count($all) > 0){
                $request[$field] = json_encode($all);
                return $request;
            }
            $request[$field] = $imageName;
            return $request;
        }
        return $request->all();
    }

    protected function uploadFileOrMultiUpload($image , $destinationPath){
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(11111,99999).'_'.time().'.'.$extension;
        if($image->move($destinationPath  , $fileName)){
            return $fileName ;
        }
    }



    protected function checkIfArray($request){
        return is_array($request) ? $request : [$request];
    }

    protected function createLog($action , $status , $messages = ''){
        $data = [
            'action' => $action,
            'model' => $this->model->getTable(),
            'status' => $status,
            'user_id' => auth()->user()->id,
            'messages' => $messages
        ];
        $this->log->create($data);
    }



}