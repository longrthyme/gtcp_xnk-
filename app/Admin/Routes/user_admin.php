<?php 
//xử lý users admin
Route::group( ['prefix' => 'user-admin'], function(){
    Route::get('/', 'UserAdminController@index')->name('admin_user_admin');
    Route::get('edit/{id}', 'UserAdminController@edit')->name('admin_user_admin.userAdminDetail');
    Route::post('post', 'UserAdminController@post')->name('admin_user_admin.postUserAdmin');
    Route::get('add', 'UserAdminController@create')->name('admin_user_admin.addUserAdmin');
    Route::get('/delete/{id}', 'UserAdminController@deleteUserAdmin')->name('admin_user_admin.delete');
    Route::get('change-password', 'UserAdminController@changePassword')->name('admin_user_admin.change_password');
    Route::post('change-password', 'UserAdminController@postChangePassword');

    Route::get('/check-password', 'AjaxController@checkPassword')->name('admin.checkPassword');
});