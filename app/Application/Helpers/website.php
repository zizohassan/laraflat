<?php
function page(){
    return \App\Application\Model\Page::select('title' , 'slug')->where('slug' , 'about_us')->first();
}

function getYouTubeId($url){
    if (preg_match('![?&]{1}v=([^&]+)!', $url . '&', $m)){
        return $video_id = $m[1];
    }
    return false;
}