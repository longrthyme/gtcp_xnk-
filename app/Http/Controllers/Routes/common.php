<?php 

	Route::post('/dang-ky-nhan-tin', array('as' => 'subscription', 'uses' => 'CustomerController@subscription'));