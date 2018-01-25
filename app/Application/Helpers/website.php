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