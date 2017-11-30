<?php

function getFileFieldsName(){
    return [
        'image' => 'image',
        'image_ar' => 'image_ar',
        'image_en' => 'image_en',
        'file' => 'file',
        'photo' => 'photo',
        'photo_en' => 'photo_en',
        'photo_ar' => 'photo_ar',
        'logo' => 'logo',
        'logo_ar' => 'logo_ar',
        'logo_en' => 'logo_en',
        'attached' => 'attached',
        'body_setting' => 'body_setting'
    ];
}

function allowExtentionsImage(){
    return [
        'png',
        'jpg',
        'jpeg',
        'gif',
        'IMG'
    ];
}

function allowExtentionsFiles(){
    return [
        'txt',
        'zip',
        'sql'
    ];
}

function getFileType($filedName , $value){
    if(in_array($filedName , getFileFieldsName())) {
        if (in_array(getExtention($value), allowExtentionsImage())) {
            return 'Image';
        }
        if (in_array(getExtention($value), allowExtentionsFiles())) {
            return 'File';
        }
    }
}

function getExtention($fileName){
    $array = explode('.' , $fileName);
    return end($array);
}


function checkIfFiledFile($array){
    $collect = [];
    foreach($array as $key => $file){
        if(in_array($key , getFileFieldsName())){
            $collect[]= $key;
        }
    }
    if(count($collect) > 0){
        return $collect;
    }
    return false;
}

function convertToImage($input)
{
    if(!is_array($input)){
        $input = [$input];
    }
    $array = [];
    foreach($input as $in){
        if($in != ''){
            $image = $in;
            $image = base64_decode($image);
            $NewName = str_random(10).rand(0,10);
            file_put_contents(public_path(env('UPLOAD_PATH')).'/'.$NewName.'.jpg', $image);
            $array[] = $NewName.'.jpg';
        }
    }
    return $array;
}