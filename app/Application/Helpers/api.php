<?php

function getTrue(){
    return true;
}

function getFalse(){
    return false;
}

function apiReturn($data , $status = '' , $error = ''){
    $s = $status == ''  ? getTrue() : getFalse();
    return json_encode(['status' => $s ,'data' => $data , 'error' => $error] , JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
}

function checkApiHaveImage($request){
    $array = [];
    foreach($request as $key => $r){
        if(in_array($key , getFileFieldsName())){
            $array[$key] = convertToImage($r);
        }else{
            $array[$key] = $r;
        }
    }
    $imagesOnly = array_intersect_key($array , getFileFieldsName());
    $getKey  =  key($imagesOnly);
    if(isset($imagesOnly[$getKey])){
        if(count($imagesOnly[$getKey]) == 1){
            $array[$getKey] = $imagesOnly[$getKey][0];
        }else{
            $array[$getKey] = '';
        }
    }
    return $array;
}