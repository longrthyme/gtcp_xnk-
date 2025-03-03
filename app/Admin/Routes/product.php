<?php 
$controllerAdminProduct = 'AdminProductController';

Route::group( ['prefix' => 'product'], function() use($controllerAdminProduct) {
	Route::get('/', $controllerAdminProduct .'@index')->name('admin_product');
	

	Route::get('create', $controllerAdminProduct .'@create')->name('admin_product.create');
	Route::get('edit/{id}', $controllerAdminProduct .'@edit')->name('admin_product.edit');
	Route::post('/post', $controllerAdminProduct .'@post')->name('admin_product.post');
	Route::post('/delete', $controllerAdminProduct .'@deleteList')->name('admin_product.delete');

	Route::post('/duyet-tin', $controllerAdminProduct .'@postDuyettin')->name('admin_product.duyet-tin');
});
Route::get('/duyet-tin', $controllerAdminProduct .'@duyettin')->name('admin_product.duyet-tin');
// Route::get('product-active/{status?}', $controllerAdminProduct .'@index')->name('admin_product.not_active');