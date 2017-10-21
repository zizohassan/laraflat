<?php
function page(){
    return \App\Application\Model\Page::select('title' , 'slug')->where('slug' , 'about_us')->first();
}