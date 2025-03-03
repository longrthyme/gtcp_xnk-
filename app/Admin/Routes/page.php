<?php 
    $nameSpaceAdminProduct = 'App\Admin\Controllers\Admin';
    //Page
    Route::group( ['prefix' => 'page'], function(){
        Route::get('/', 'PageController@index')->name('admin_page');
        Route::get('create', 'PageController@create')->name('admin_page.create');
        Route::get('/edit/{id}', 'PageController@edit')->name('admin_page.edit');
        Route::post('post', 'PageController@post')->name('admin_page.post');
        Route::post('delete', 'PageController@deleteList')->name('admin_page.delete');
    });