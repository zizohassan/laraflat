<?php


function status(){
    return [
        'Active' => adminTrans('home' ,'Active'),
        'Deactive' => adminTrans('home' ,'Deactive'),
    ];
}

function setting_type(){
    return [
        'text' => adminTrans('home' ,'text'),
        'textarea' => adminTrans('home' ,'textarea'),
        'image' => adminTrans('home' ,'image'),
    ];

}

function type(){
    return [
        'Main' => adminTrans('home' ,'main'),
        'Sub' => adminTrans('home' ,'sub'),
    ];
}


function menuTarget(){
    return [
        'blank' => adminTrans('home' ,'blank'),
        'self' => adminTrans('home' ,'self'),
    ];
}



function permissionType(){
    return [
        'on' => adminTrans('home' ,'on'),
        'off' => adminTrans('home' ,'off'),
    ];
}

function removeFromArray($orignalArray , $expectArray){
    return array_values(array_diff($orignalArray, $expectArray));
}

function rename_keys($array, $replacement_keys)  {
    if(count($replacement_keys) > 0){
        return array_combine($replacement_keys, array_values($array));
    }
}


function extractJsonInfo($data)
{
    $newData = (array) json_decode($data);
    foreach ($newData as $key => $d) {
        if (is_object($d)) {
            $newData[$key] = (array)$d;
        }
    }
    return $newData;
}


