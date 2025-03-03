<?php 

Route::middleware(['blockIP'])->group(function () {
    Route::get('payment/return-ipn', 'Payment\VNPayController@payment_ipn')->name('payment.ipn');
});

