<?php 
$controllerAdminVideo = 'ShopVideoController';
$controllerAdminVideoItem = 'ShopVideoItemController';

Route::group( ['prefix' => 'video'], function() use($controllerAdminVideo) {
	Route::get('{product_id}/{id?}', $controllerAdminVideo .'@index')->name('admin_video')->where(['product_id' => '[0-9]', 'id' => '[0-9]']);
	Route::get('create', $controllerAdminVideo .'@create')->name('admin_video.create');
	Route::get('edit/{id}', $controllerAdminVideo .'@edit')->name('admin_video.edit');
	Route::post('/post', $controllerAdminVideo .'@post')->name('admin_video.post');
	Route::post('/delete', $controllerAdminVideo .'@deleteList')->name('admin_video.delete');
});

Route::group( ['prefix' => 'video-item'], function() use($controllerAdminVideoItem) {
	Route::get('/', $controllerAdminVideoItem .'@index')->name('admin_video_item');
	Route::get('create', $controllerAdminVideoItem .'@create')->name('admin_video_item.create');
	Route::get('edit/{id}', $controllerAdminVideoItem .'@edit')->name('admin_video_item.edit');
	Route::post('/post', $controllerAdminVideoItem .'@post')->name('admin_video_item.post');
	Route::post('/delete', $controllerAdminVideoItem .'@deleteList')->name('admin_video_item.delete');
});