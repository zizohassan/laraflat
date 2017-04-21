<?php

Route::get('/', function(){
    return view('welcome');
});

Route::get('/user', 'TestController@index');
Route::get('/user/item/{id?}', 'TestController@store');
Route::get('user/{id}/delete', 'TestController@delete');


Auth::routes();
