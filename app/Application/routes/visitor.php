<?php

Route::get('/', 'HomeController@welcome');

Route::get('contact' , 'ContactController@index');
Route::post('contact' , 'ContactController@storeContact');
Route::get('deleteFile/{model}/{id}', 'HomeController@deleteImage');

Auth::routes();


Route::get('page' , 'PageController@index');
Route::get('page/{id}/view' , 'PageController@getById');


