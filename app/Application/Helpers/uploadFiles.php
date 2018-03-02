<?php

function getFileFieldsName()
{
    return fileFields() + getImageFields();
}

function fileFields()
{
    return [
        'file[]' => 'file[]',
        'file' => 'file',
        'files' => 'files',
        'files[]' => 'files[]',
    ];
}


function getImageFields()
{
    return [
        'image' => 'image',
        'image[]' => 'image[]',
        'image_ar' => 'image_ar',
        'image_en' => 'image_en',
        'image_ar[]' => 'image_ar[]',
        'image_en[]' => 'image_en[]',
        'photo' => 'photo',
        'photo[]' => 'photo[]',
        'photo_en' => 'photo_en',
        'photo_ar' => 'photo_ar',
        'photo_en[]' => 'photo_en[]',
        'photo_ar[]' => 'photo_ar[]',
        'logo' => 'logo',
        'logo_ar' => 'logo_ar',
        'logo_en' => 'logo_en',
        'logo[]' => 'logo[]',
        'logo_ar[]' => 'logo_ar[]',
        'logo_en[]' => 'logo_en[]',
        'attached' => 'attached',
        'body_setting' => 'body_setting'
    ];
}

function allowExtentionsImage()
{
    return [
        'png',
        'jpg',
        'jpeg',
        'gif',
        'IMG'
    ];
}

function allowExtentionsFiles()
{
    return [
        'txt',
        'zip',
        'sql',
        'xls',
        'xlm',
        'xla',
        'xlc',
        'xlt',
        'xlw',
        'pdf',
        'xla',
        'docx',
        'rtf',
        'doc',
        'dot',
        'dotx',
        'docm',
        'xlsx',
        'xlsm',
        'xltx',
        'dotm',
        'xltm',
        'xlam',
        'xlsb'
    ];
}

function getFileType($filedName, $value)
{
    if (in_array($filedName, getFileFieldsName())) {
        if (in_array(getExtention($value), allowExtentionsImage())) {
            return 'Image';
        }
        if (in_array(getExtention($value), allowExtentionsFiles())) {
            return 'File';
        }
    }
}

function getExtention($fileName)
{
    $array = explode('.', $fileName);
    return end($array);
}


function checkIfFiledFile($array)
{
    $collect = [];
    foreach ($array as $key => $file) {
        if (in_array($key, getFileFieldsName())) {
            $collect[] = $key;
        }
    }
    return count($collect) > 0 ? $collect : [];
}

function convertToImage($input)
{
    if (!is_array($input)) {
        $input = [$input];
    }
    $array = [];
    foreach ($input as $in) {
        if ($in != '') {
            $image = $in;
            $image = base64_decode($image);
            $NewName = str_random(10) . rand(0, 10);
            file_put_contents(public_path(env('UPLOAD_PATH')) . '/' . $NewName . '.jpg', $image);
            $array[] = $NewName . '.jpg';
        }
    }
    return $array;
}


function returnFilesImages($item, $name = "image")
{
    $array = [
        'image' => [],
        'file' => []
    ];
    if ($item->{$name}) {
        if (json_decode($item->{$name})) {
            $images = json_decode($item->{$name});
            foreach ($images as $image) {
                if (getFileType($name, $image) == "Image") {
                    array_push($array['image'], $image);
                }
                if (getFileType($name, $image) == "File") {
                    array_push($array['file'], $image);
                }
            }
        }
    }
    return $array;
}

function getImageFromJson($item, $name = "image", $index = 0)
{
    if ($item->{$name}) {
        if (json_decode($item->{$name})) {
            $image = json_decode($item->{$name});
            if (isset($image[$index])) {
                if (getFileType($name, $image[$index]) == ucfirst($name)) {
                    return $image[$index];
                }
                $index++;
                return getImageFromJson($item, $name, $index);
            }
        }
    }
    return env('NONE_IMAGE');
}
