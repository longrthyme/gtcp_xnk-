<?php 
	Route::group(['prefix' => 'ajax'], function() {
        Route::post('change-attr', 'ProductController@changeAttr')->name('ajax.attr.change');

        Route::post('place-select', 'LocationController@placeSelect')->name('ajax.place_select');

        Route::post('save-post', 'ProductController@savePost')->name('product.save');

        Route::post('show-phone', 'CustomerController@showphone');
        Route::post('author-vote', 'CustomerController@vote');
    });