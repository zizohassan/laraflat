<?php

function loadSidebarWidget(){
    $path = app_path('Application/views/website/sidebar');
    loadWidget($path);
}

function loadHomePageWidget(){
    $path = app_path('Application/views/website/homepage');
    loadWidget($path);
}

function loadWidget($path){
   $files =  \Illuminate\Support\Facades\File::Files($path);
    if(count($files) > 0){
        foreach($files as $file){
            require_once  $path.DS.$file->getFileName();
        }
    }
}