<?php 

//Post
   Route::group( ['prefix' => 'post'], function(){
       Route::get('/', 'AdminPostController@index')->name('admin_post');
       Route::get('create', 'AdminPostController@create')->name('admin_post.create');
       Route::get('edit/{id}', 'AdminPostController@edit')->name('admin_post.edit');
       Route::post('/post', 'AdminPostController@post')->name('admin_post.post');
       Route::post('/delete', 'AdminPostController@deleteList')->name('admin_post.delete');
   });

   //Category Post
   Route::group( ['prefix' => 'category-post'], function(){
       Route::get('/', 'AdminPostCategoryController@index')->name('admin_post.category');
       Route::get('create', 'AdminPostCategoryController@create')->name('admin_post.category_create');
       Route::get('{id}', 'AdminPostCategoryController@edit')->name('admin_post.category_edit');
       Route::post('/post', 'AdminPostCategoryController@post')->name('admin_post.category_post');
       Route::post('/delete', 'AdminPostCategoryController@deleteList')->name('admin_post.category_delete');
   });