<?php 

Route::group( ['prefix' => 'purchase'], function(){
    // Route::get('payment-history', 'PaymentController@paymentHistory')->name('admin.payment_history');
    Route::get('/', 'PurchaseController@index')->name('admin_purchase');
    Route::get('history/{id}', 'PurchaseController@edit')->name('admin_purchase.edit');
    Route::post('update', 'PurchaseController@post')->name('admin_purchase.post');
    // Route::get('payment-view-tip', 'PurchaseController@viewTipHistory')->name('admin_tip.payment_history');
});