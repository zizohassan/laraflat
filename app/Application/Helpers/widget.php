<?php

function loadSidebarWidget(){
    $path = app_path('Application/views/website/sidebar');
    return loadWidget($path , 'website.sidebar.');
}

function loadHomePageWidget(){
    $path = app_path('Application/views/website/homepage');
    return loadWidget($path , 'website.homepage.');
}

function loadWidget($path , $viewpath){
   $files = getFiles($path);
    if(count($files) > 0){
        $array = [];
        foreach($files as $file){
            $array[] = $viewpath.explode('.' , $file->getFileName())[0];
        }
        return $array;
    }
}

function getFiles($path){
    return \Illuminate\Support\Facades\File::Files($path);
}

