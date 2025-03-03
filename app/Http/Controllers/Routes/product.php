<?php 
    Route::get('/search', 'ProductController@search')->name('search');
    Route::get('/wishlist', array('as' => 'customer.wishlist', 'uses' => 'CustomerController@wishlist'));
    Route::post('product-filter/{slug}/{slug_sub?}', 'ProductController@category')->name('product.filter_ajax');
    
    Route::get('product/yeu-cau-chao-gia/{id}', 'ProductController@baogia')->name('product.baogia');
    Route::post('product/yeu-cau-chao-gia/{id}', 'ProductController@baogiaProcess');
    
    Route::get('{slug}/{slug_sub?}', 'ProductController@category')->name('product');
    
    Route::post('add-to-wishlist', 'ProductController@wishlist')->name('product.wishlist');
