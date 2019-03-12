<?php


Route::prefix('permiso')->group(function () {

    Route::namespace('Betalectic\Permiso\Http\Controllers')->group(function () {
        Route::get('groups', 'GroupController@index');
        Route::post('groups', 'GroupController@store');
        Route::get('permissions', 'PermissionsController@index');
        Route::post('grant', 'GrantController@store');
        Route::get('access/{user}', 'AccessController@index');
    });
});


