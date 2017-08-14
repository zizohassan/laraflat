<?php

namespace App\Application\Controllers\Traits;

trait UploadTrait{

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

}