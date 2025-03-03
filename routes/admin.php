<?php 

// Route xử lý cho admin
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('admin.login');
    Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('/404', 'AdminController@error')->name('adminError');

    Route::get('deny', 'DashboardController@deny')->name('admin.deny');
    Route::get('data_not_found', 'DashboardController@dataNotFound')->name('admin.data_not_found');
    Route::get('deny_single', 'DashboardController@denySingle')->name('admin.deny_single');
        
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
         //các route của quản trị viên sẽ được viết trong group này, còn chức năng của user sẽ viết ngoài route
        Route::group(['middleware' => 'checkAdminPermission'], function () {

            foreach (glob(app_path() .'/Admin/Routes/*.php') as $filename) {
                require_once $filename;
            }

        });
    });