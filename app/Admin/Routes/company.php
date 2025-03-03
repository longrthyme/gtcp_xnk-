<?php 
    $name = 'admin_company';
//Post
   Route::group( ['prefix' => 'company'], function() use($name){
       Route::get('/', 'CompanyController@index')->name($name);
       Route::get('create', 'CompanyController@create')->name($name .'.create');
       Route::get('edit/{id}', 'CompanyController@edit')->name($name .'.edit');
       Route::post('/post', 'CompanyController@post')->name($name .'.post');
       Route::post('/delete', 'CompanyController@deleteList')->name($name .'.delete');
   });
