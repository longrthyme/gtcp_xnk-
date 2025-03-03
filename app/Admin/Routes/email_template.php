<?php 
    //email template
    Route::group(['prefix' => 'email-template'], function () {
        Route::get('/', 'EmailTemplateController@index')->name('admin.email_template');
        Route::get('edit/{id}', 'EmailTemplateController@edit')->name('admin.email_template.edit');
        Route::get('add', 'EmailTemplateController@create')->name('admin.email_template.create');
        Route::post('post', 'EmailTemplateController@post')->name('admin.email_template.post');
        Route::post('delete', 'EmailTemplateController@deleteList')->name('admin.email_template.delete');
    });