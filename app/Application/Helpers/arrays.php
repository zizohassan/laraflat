<?php


function status(){
    return [
        'Active' => 'Active',
        'Deactive' => 'Deactive'
    ];
}

function type(){
    return [
        'Main' => 'Main',
        'Sub' => 'Sub'
    ];
}


function permissionType(){
    return [
        'on' => 'On',
        'off' => 'Off'
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