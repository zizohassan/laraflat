<?php
require_once __DIR__.'/visitor.php';
require_once __DIR__.'/auth.php';
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'] , function() {
    Route::get('icons' , function(){
        return view('admin.layout.static.icons');
    });
    Route::get('docs' , function(){
        return view('vendor.apidoc.index');
    });
    Route::group(['middleware' => ['auth','admin' , 'permissions']] , function(){
        require_once __DIR__ . '/admin.php';
    });
});
require_once __DIR__.'/errors.php';






