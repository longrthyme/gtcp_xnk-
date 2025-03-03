<?php 
	//Setting
	Route::group( ['prefix' => 'theme-option'], function(){
		Route::get('/', 'AdminController@getThemeOption')->name('admin_theme_option');
		Route::post('/', 'AdminController@postThemeOption')->name('admin_theme_option.post');
	});