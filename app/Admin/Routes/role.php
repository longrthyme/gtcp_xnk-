<?php 
Route::group(['prefix' => 'role'], function () {
    Route::get('/', 'Auth\RoleController@index')->name('admin_role.index');
    Route::get('create', 'Auth\RoleController@create')->name('admin_role.create');
    Route::get('/edit/{id}', 'Auth\RoleController@edit')->name('admin_role.edit');
    Route::post('/post', 'Auth\RoleController@post')->name('admin_role.post');
    Route::get('/delete/{id}', 'Auth\RoleController@delete')->name('admin_role.delete');
});

