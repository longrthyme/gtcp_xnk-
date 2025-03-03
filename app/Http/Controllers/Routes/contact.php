<?php 

    //contact
    Route::post('/get-contact-form/{type}', array('as' => 'contact.get', 'uses' => 'ContactController@getContact'));

    Route::post('contact/send', 'ContactController@submit')->name('contact.submit');
    Route::post('ajax/contact', 'ContactController@sendContact')->name('contact.send');
    