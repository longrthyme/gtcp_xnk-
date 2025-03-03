<?php 
//Slider Home
Route::group(['prefix' => 'slider'], function () {
    Route::get('/', 'SliderController@index')->name('admin_slider');
    Route::get('create', 'SliderController@create')->name('admin_slider.create');
    Route::get('{id}', 'SliderController@edit')->name('admin_slider.edit');
    Route::post('post', 'SliderController@post')->name('admin_slider.post');
    Route::post('insert', 'SliderController@insertSlider')->name('admin.slider.insert');
    Route::post('edit', 'SliderController@editSlider')->name('admin.slider.insert');
    Route::post('delete', 'SliderController@deleteSlider')->name('admin.slider.delete');

    Route::post('sort', 'SliderController@updateSort')->name('admin.slider.sort');
});