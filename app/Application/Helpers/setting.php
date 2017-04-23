<?php

function getSetting($name){
    return \App\Application\Model\Setting::where('name' , $name)->first()->body_setting;
}