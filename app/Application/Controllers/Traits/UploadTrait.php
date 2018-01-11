<?php

namespace App\Application\Controllers\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait UploadTrait{

    public function uploadFile($request , $field){
        if($request->file($field) != null){
            $destinationPath = env('UPLOAD_PATH');
            $all = [];
            $imageName = '';
            if(is_array($request->file($field))){
                foreach($request->file($field)  as $file){
                    if(getFileType($field , $file->getClientOriginalName()) == 'Image'){
                        $all[] = $this->uploadFileOrMultiUpload($file , $destinationPath , $field);
                    }else{
                        $all[] = $this->uploadFiles($file , $destinationPath);
                    }
                }
            }else{
                if(getFileType($field , $request->file($field)->getClientOriginalName()) == 'Image'){
                    $imageName = $this->uploadFileOrMultiUpload($request->file($field) , $destinationPath , $field);
                }else{
                    $imageName = $this->uploadFiles($request->file($field) , $destinationPath);
                }
            }
            if(count($all) > 0){
                $request->request->add([$field => json_encode($all)]);
                return $request->request->all();
            }
            $request->request->add([$field => $imageName]);
            return $request->request->all();
        }
    }

    protected function uploadFileOrMultiUpload($image , $destinationPath,$field){
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(11111,99999).'_'.time().'.'.$extension;
        $image  = Image::make($image);
        /*
         * upload resize image
         */
        $width = env('SMALL_IAMGE_WIDTH');
        $height = env('SMALL_IAMGE_HEIGHT');
        $model = strtolower(class_basename($this->model));
        $path = base_path('config/'.$model.'.php');
        if(file_exists($path)){
            $width = config($model.'.'.$field.'.width');
            $height = config($model.'.'.$field.'.height');
        }
        $image->save(path($destinationPath.DS.$fileName));
        $image->resize(path($width), path($height) , function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $image->save(path(env('SMALL_IMAGE_PATH').DS.$fileName) , path(env('IMAGE_RESLUTION')));
        return $fileName;
    }



    protected function uploadFiles($image , $destinationPath){
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(11111,99999).'_'.time().'.'.$extension;
        if($image->move($destinationPath  , $fileName)){
            return $fileName ;
        }
    }

}