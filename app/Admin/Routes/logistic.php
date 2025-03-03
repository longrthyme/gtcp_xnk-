<?php 
    $name = 'admin_logistic';
//Post
   Route::group( ['prefix' => 'logistic'], function() use($name){
       Route::get('/', 'LogisticController@index')->name($name);
       Route::get('create', 'LogisticController@create')->name($name .'.create');
       Route::get('edit/{id}', 'LogisticController@edit')->name($name .'.edit');
       Route::post('/post', 'LogisticController@post')->name($name .'.post');
       Route::post('/delete', 'LogisticController@deleteList')->name($name .'.delete');
   });

   //Category Post
   Route::group( ['prefix' => 'logistic-category'], function() use($name){
       Route::get('/', 'LogisticCategoryController@index')->name($name .'.category');
       Route::get('create', 'LogisticCategoryController@create')->name($name .'.category_create');
       Route::get('{id}', 'LogisticCategoryController@edit')->name($name .'.category_edit');
       Route::post('/post', 'LogisticCategoryController@post')->name($name .'.category_post');
       Route::post('/delete', 'LogisticCategoryController@deleteList')->name($name .'.category_delete');
   });