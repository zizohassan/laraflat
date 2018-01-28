<?php
            #Page
            Route::get('page/getById/{id}/{lang?}', 'PageApi@getById');
            Route::get('page/delete/{id}', 'PageApi@delete');
            Route::post('page/add', 'PageApi@add');
            Route::post('page/update/{id}', 'PageApi@update');
            Route::get('page/{limit?}/{offset?}/{lang?}', 'PageApi@index');