<?php
                #### Page control
                Route::get('page', 'PageController@index');
                Route::get('page/item/{id?}', 'PageController@show');
                Route::post('page/item', 'PageController@store');
                Route::post('page/item/{id}', 'PageController@update');
                Route::get('page/{id}/delete', 'PageController@destroy');
                Route::get('page/{id}/view', 'PageController@getById');
                        Route::post('page/add/comment/{id}' , 'PageCommentController@addComment');
                        Route::post('page/update/comment/{id}' , 'PageCommentController@updateComment');
                        Route::get('page/delete/comment/{id}' , 'PageCommentController@deleteComment');
                        