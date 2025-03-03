<?php 
Route::group( ['prefix' => 'permission'], function(){
    Route::get('/', 'Auth\PermissionController@index')->name('admin_permission.index');
    Route::get('create', 'Auth\PermissionController@create')->name('admin_permission.create');
    Route::get('/edit/{id}', 'Auth\PermissionController@edit')->name('admin_permission.edit');
    Route::post('/post', 'Auth\PermissionController@post')->name('admin_permission.post');
    Route::get('/delete/{id}', 'Auth\PermissionController@delete')->name('admin_permission.delete');
});