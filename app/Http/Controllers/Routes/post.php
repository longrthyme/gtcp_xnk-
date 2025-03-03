<?php 

	Route::get('news.html', 'NewsController@index')->name('news');

	//news
    Route::get('{slug}.html', 'PageController@page')->where(['slug' => '[a-zA-Z0-9$-_.+!]+'])->name('post.single');