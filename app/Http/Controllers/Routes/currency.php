<?php 
	//change currency
 	Route::get('currency/{code}', function ($code) {
       session(['currency' => $code]);
       if (request()->fullUrl() === redirect()->back()->getTargetUrl()) {
           return redirect()->route('home');
       }
       return back();
   })->name('currency');