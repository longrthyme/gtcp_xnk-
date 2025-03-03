<?php 

//xử lý users
   Route::group(['prefix' => 'user'], function () {
       Route::get('/', 'UserController@index')->name('admin_user');
       Route::get('edit/{id}', 'UserController@userDetail')->name('admin_user.edit');
       Route::get('add', 'UserController@create')->name('admin_user.create');
       Route::post('post', 'UserController@post')->name('admin_user.post');
       Route::get('delete/{id}', 'UserController@deleteUser')->name('admin_user.delete');
       Route::get('export', 'UserController@exportCustomer')->name('admin_user.export');
   });
   Route::group(['prefix' => 'user-verify'], function () {
       Route::get('/', 'UserController@verify')->name('admin_user.verify');
       Route::get('view/{id}', 'UserController@verifyDetail')->name('admin_user.verify_edit');
       Route::post('verify', 'UserController@verifyPost')->name('admin_user.verify_post');
   });