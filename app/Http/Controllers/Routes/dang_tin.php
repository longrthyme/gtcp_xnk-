<?php 

//dang tin
Route::group(['middleware' => ['auth', 'IsVerifyEmail']], function () {

    Route::group(['prefix' => 'dang-tin'], function() {
        Route::get('/', 'User\DangtinController@index')->name('dangtin');
        Route::post('/', 'User\DangtinController@post')->name('dangtin.post');
        Route::post('/category-selected', 'User\DangtinController@categorySelect')->name('dangtin.category_select');

        Route::post('package', 'User\DangtinController@package')->name('dangtin.post');
        Route::post('check-wallet', 'CustomerController@checkWallet')->name('dangtin.check.wallet');

        Route::group(['prefix' => 'ajax'], function() {
            Route::post('get-post-type-content', 'User\DangtinController@getPostTypeContent')->name('dangtin.get_post_type_content');
        });
    });

    //dang tin dich vu
    Route::get('dang-tin-dich-vu', 'User\DangtinController@service')->name('dangtin.service');
    Route::post('dang-tin-dich-vu', 'User\DangtinController@postService');
    
    

    Route::get('/sua-tin/{id}', 'User\DangtinController@editPost')->name('dangtin.edit');
    Route::get('/delete-my-post/{id}', 'CustomerController@deletePost')->name('dangtin.delete');

    Route::get('/bds-info-author', 'CustomerController@getPhone')->name('bds.info.phone');

});

Route::group(['prefix' => 'dang-tin'], function() {
    Route::get('success', 'User\DangtinController@success')->name('dangtin.success');
});