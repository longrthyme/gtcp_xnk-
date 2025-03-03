<?php 
$controllerAdminProduct = 'AdminProductOptionController';

Route::group( ['prefix' => 'product-option'], function() use($controllerAdminProduct) {
	Route::get('/', $controllerAdminProduct .'@index')->name('admin_product.option');
	Route::get('create', $controllerAdminProduct .'@create')->name('admin_product.option_create');
	Route::get('edit/{id}', $controllerAdminProduct .'@edit')->name('admin_product.option_edit');
	Route::post('/post', $controllerAdminProduct .'@store')->name('admin_product.option_post');
	Route::get('/delete/{id}', $controllerAdminProduct .'@delete')->name('admin_product.option_delete');
});