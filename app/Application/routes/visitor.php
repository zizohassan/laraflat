<?php

Route::get('/', 'HomeController@welcome');

Route::get('/page/{slug}', 'HomeController@getPageBySlug');

Auth::routes();
