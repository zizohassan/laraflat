<?php


function status()
{
    return [
        'Active' => trans('home.Active'),
        'Deactive' => trans('home.Deactive'),
    ];
}

function setting_type()
{
    return [
        'text' => trans('home.text'),
        'textarea' => trans('home.textarea'),
        'image' => trans('home.image'),
    ];

}

function type()
{
    return [
        'Main' => trans('home.main'),
        'Sub' => trans('home.sub'),
    ];
}


function menuTarget()
{
    return [
        'blank' => trans('home.blank'),
        'self' => trans('home.self'),
    ];
}


function permissionType()
{
    return [
        'on' => trans('home.on'),
        'off' => trans('home.off'),
    ];
}

function removeFromArray($orignalArray, $expectArray)
{
    return array_values(array_diff($orignalArray, $expectArray));
}

function rename_keys($array, $replacement_keys)
{
    if (count($replacement_keys) > 0) {
        return array_combine($replacement_keys, array_values($array));
    }
}


function extractJsonInfo($data)
{
    $newData = (array)json_decode($data);
    foreach ($newData as $key => $d) {
        if (is_object($d)) {
            $newData[$key] = (array)$d;
        }
    }
    return $newData;
}

function getMigrationType(){
    return [
        'string',
        'boolean',
        'char',
        'date',
        'double',
        'text',
        'mediumText',
        'longText',
        'float',
        'integer',
        'ipAddress',
        'tinyInteger'
    ];
}


function notFilter()
{
    return ['icon', 'body', 'des', 'meta', 'keywords' , 'lng' , 'lat' , 'youtube' , 'url'] + getFileFieldsName();
}


