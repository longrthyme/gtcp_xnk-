<?php 

	Route::group(['prefix' => 'package'], function () {
        Route::get('/', 'AdminPackageController@index')->name('admin.package');
        Route::get('create', 'AdminPackageController@create')->name('admin.package.create');
        Route::get('{id}', 'AdminPackageController@edit')->name('admin.package.edit');
        Route::post('post', 'AdminPackageController@post')->name('admin.package.post');
        Route::post('show-home', 'AdminPackageController@showHome')->name('admin.package.show_home');
        Route::post('priority', 'AdminPackageController@priority')->name('admin.package.priority');
    });

    $controllerAdminPackageOption = 'AdminPackageOptionController';

	Route::group( ['prefix' => 'package-option'], function() use($controllerAdminPackageOption) {
		Route::get('/', $controllerAdminPackageOption .'@index')->name('admin_package.option');
		Route::get('create', $controllerAdminPackageOption .'@create')->name('admin_package.option_create');
		Route::get('edit/{id}', $controllerAdminPackageOption .'@edit')->name('admin_package.option_edit');
		Route::post('/post', $controllerAdminPackageOption .'@store')->name('admin_package.option_post');
		Route::get('/delete/{id}', $controllerAdminPackageOption .'@delete')->name('admin_package.option_delete');
	});
	Route::group( ['prefix' => 'package-day'], function() {
		Route::get('/', 'AdminPackageDayController@index')->name('admin_package.day');
		Route::get('create', 'AdminPackageDayController@create')->name('admin_package.day_create');
		Route::get('edit/{id}', 'AdminPackageDayController@edit')->name('admin_package.day_edit');
		Route::post('/post', 'AdminPackageDayController@store')->name('admin_package.day_post');
		Route::get('/delete/{id}', 'AdminPackageDayController@delete')->name('admin_package.day_delete');
	});