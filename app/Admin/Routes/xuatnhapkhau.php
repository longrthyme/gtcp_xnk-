<?php 
    $name = 'admin_xnk';
//Post
   Route::group( ['prefix' => 'xuat-nhap-khau'], function() use($name){
       Route::get('/', 'XNKController@index')->name($name);
       Route::get('create', 'XNKController@create')->name($name .'.create');
       Route::get('edit/{id}', 'XNKController@edit')->name($name .'.edit');
       Route::post('/post', 'XNKController@post')->name($name .'.post');
       Route::post('/delete', 'XNKController@deleteList')->name($name .'.delete');
   });

   //Category Post
   Route::group( ['prefix' => 'xuat-nhap-khau-category'], function() use($name){
       Route::get('/', 'XNKCategoryController@index')->name($name .'.category');
       Route::get('create', 'XNKCategoryController@create')->name($name .'.category_create');
       Route::get('{id}', 'XNKCategoryController@edit')->name($name .'.category_edit');
       Route::post('/post', 'XNKCategoryController@post')->name($name .'.category_post');
       Route::post('/delete', 'XNKCategoryController@deleteList')->name($name .'.category_delete');
   });