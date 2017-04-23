<?php

function getFileFieldsName(){
    return [
        'image',
        'file',
        'photo',
        'logo',
        'attached',
        'body_setting'
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
    foreach($array as $key => $file){
        if(in_array($key , getFileFieldsName())){
            return $key;
        }
    }
    return false;
}