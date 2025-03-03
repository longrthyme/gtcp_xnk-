<?php 
//payment method
Route::group(['prefix' => 'payment-method'], function () {
    Route::get('/', 'PaymentMethodController@index')->name('admin_payment_method');
    Route::get('create', 'PaymentMethodController@create')->name('admin_payment_method.create');
    Route::get('edit/{id}', 'PaymentMethodController@edit')->name('admin_payment_method.edit');
    Route::post('post', 'PaymentMethodController@store')->name('admin_payment_method.post');
    Route::get('delete/{id}', 'PaymentMethodController@delete')->name('admin_payment_method.delete');
    Route::post('setting-delete', 'PaymentMethodController@settingDelete')->name('admin_payment_method.setting_delete');
    Route::post('payment-method-country', 'PaymentMethodController@collectionPaymentMethod')->name('admin_payment_method.collection_payment_method');
});

Route::group(['prefix' => 'payment-method/item'], function () {
    Route::get('create', 'PaymentMethodItemController@index')->name('admin_payment_method.item_create');
    Route::get('edit/{id}', 'PaymentMethodItemController@edit')->name('admin_payment_method.item_edit');
    Route::post('post', 'PaymentMethodItemController@store')->name('admin_payment_method.item_post');
    Route::get('delete/{id}', 'PaymentMethodItemController@delete')->name('admin_payment_method.item_delete');
    Route::get('/{id}', 'PaymentMethodItemController@index')->name('admin_payment_method.item');
});