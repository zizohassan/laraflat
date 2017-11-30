<?php
Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect', 'localizationRedirect']] , function(){
    Route::group(['prefix' =>'admin' , 'namespace' => 'Admin' ,'middleware' => ['auth','admin' , 'admin-permissions']] , function() {
        require_once __DIR__ . '/admin.php';
    });
    Route::group([ 'namespace' => 'Website'] , function() {
        require_once __DIR__ . '/visitor.php';
        Route::group(['middleware' => ['auth' , 'website-permissions']] , function(){
            require_once __DIR__ . '/auth.php';
            require_once __DIR__ . '/appendWebsite.php';
        });
    });
});
require_once __DIR__.'/errors.php';






