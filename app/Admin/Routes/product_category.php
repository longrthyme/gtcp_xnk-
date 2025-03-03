<?php 
$controllerAdminProductCategory = 'AdminCategoryController';

Route::group( ['prefix' => 'product-category'], function() use($controllerAdminProductCategory) {
	Route::get('/', $controllerAdminProductCategory .'@index')->name('admin_product.category');
	Route::get('create', $controllerAdminProductCategory .'@create')->name('admin_product.category_create');
	Route::get('{id}', $controllerAdminProductCategory .'@edit')->name('admin_product.category_edit');
	Route::post('/post', $controllerAdminProductCategory .'@post')->name('admin_product.category_post');
	Route::post('/delete', $controllerAdminProductCategory .'@deleteList')->name('admin_product.category_delete');
});