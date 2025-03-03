<?php 

	//client
   Route::group(['prefix' => 'client'], function () {
      Route::get('/', 'AdminClientController@index')->name('admin_client');
      Route::get('edit/{id}', 'AdminClientController@edit')->name('admin_client.edit');
      Route::get('add', 'AdminClientController@create')->name('admin_client.create');
      Route::post('post', 'AdminClientController@post')->name('admin_client.post');
      Route::post('/delete', 'AdminClientController@deleteList')->name('admin_client.delete');
   });
   //client category
   Route::group(['prefix' => 'client-category'], function () {
      Route::get('/', 'AdminClientCategoryController@index')->name('admin_client.category');
      Route::get('edit/{id}', 'AdminClientCategoryController@edit')->name('admin_client.category_edit');
      Route::get('add', 'AdminClientCategoryController@create')->name('admin_client.category_create');
      Route::post('post', 'AdminClientCategoryController@post')->name('admin_client.category_post');
      Route::post('/delete', 'AdminClientCategoryController@deleteList')->name('admin_client.category_delete');
   });