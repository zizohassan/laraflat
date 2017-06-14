<?php

function layoutPath($file){
    return "admin.theme.".env('THEME').".".$file;
}

function layoutMessage(){
    return layoutPath("layout.messages");
}

function layoutForm(){
    return layoutPath("layout.form");
}
function layoutExtend(){
    return layoutPath("layout.app");
}

function layoutMenu(){
    return layoutPath("layout.menu");
}

function layoutHeader(){
    return layoutPath("layout.header");
}

function layoutBreadcrumb(){
    return layoutPath("layout.breadcrumb");
}

function layoutTable(){
    return layoutPath("layout.table");
}