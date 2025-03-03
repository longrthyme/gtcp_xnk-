<?php 

	Route::group(['prefix' => 'location'], function() {
      Route::post('district', 'LocationController@getDistrict')->name('location.district');
      Route::post('ward', 'LocationController@getWard')->name('location.ward');
      Route::post('search-place', 'LocationController@searchPlace')->name('location.search_place');
   });