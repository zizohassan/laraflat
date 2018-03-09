<?php
function page($id = null){
    if($id != null){
        return \App\Application\Model\Page::infOrFail($id);
    }
    return \App\Application\Model\Page::get();
}

function getYouTubeId($url){
    if (preg_match('![?&]{1}v=([^&]+)!', $url . '&', $m)){
        return $video_id = $m[1];
    }
    return false;
}

function small($image = ''){
    return $image == '' ? env('NONE_IMAGE') : imageExist($image) ? url('/'.env('SMALL_IMAGE_PATH').'/'.$image) : large($image);
}

function imageExist($imageName , $env = 'SMALL_IMAGE_PATH'){
    return file_exists(public_path(env($env).'/'.$imageName)) ? true : false;
}

function large($image= ''){
    return $image == '' ? env('NONE_IMAGE') : imageExist($image , 'UPLOAD_PATH') ?  url('/'.env('UPLOAD_PATH').'/'.$image) :  env('NONE_IMAGE')  ;
}