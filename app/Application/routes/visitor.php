<?php

Route::get('/', 'HomeController@welcome');

Route::get('contact' , 'ContactController@index');
Route::post('contact' , 'ContactController@storeContact');

Auth::routes();


Route::get('page' , 'PageController@index');
Route::get('page/{id}/view' , 'PageController@getById');


