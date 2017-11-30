<?php

namespace App\Application\Controllers\Traits;

use Intervention\Image\Facades\Image;

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
            if(count($all) > 0){
                $request->request->add([$field => json_encode($all)]);
                return $request->request->all();
            }
            $request->request->add([$field => $imageName]);
            return $request->request->all();
        }
    }

    protected function uploadFileOrMultiUpload($image , $destinationPath){
        $extension = $image->getClientOriginalExtension();
        $fileName = rand(11111,99999).'_'.time().'.'.$extension;
        $image  = Image::make($image);
        /*
         * upload resize image
         */
        $image->save($destinationPath.'/'.$fileName);
        $image->fit(env('SMALL_IAMGE_WIDTH'), env('SMALL_IAMGE_HEIGHT'));
        $image->save(env('SMALL_IMAGE_PATH').'/'.$fileName , env('IMAGE_RESLUTION'));
        return $fileName;
    }

}