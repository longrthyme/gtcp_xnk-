<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('clear-cache', function() {
     Artisan::call('config:cache');
     Artisan::call('cache:clear');
    return 'DONE'; //Return anything
});


// dd(Route::localizedUrl());
Route::get('/', 'PageController@index')->name('index');
Route::get('/sitemap', 'SitemapController@index')->name('sitemap');
Route::get('/bao-cao', 'Api\BCTController@baocao')->name('api.bct_baocao');
Route::post('/login-bao-cao', 'Api\BCTController@loginBaocao')->name('api.bct_baocao_login');
Route::get('/logout-bao-cao', 'Api\BCTController@logout')->name('api.bct_baocao_logout');

Route::middleware(SC_FRONT_MIDDLEWARE)
    ->group(function (){
        foreach (glob(app_path() .'/Http/Controllers/Routes/*.php') as $filename) {
            require $filename;
        }
    }
);

Route::group(
    [
        'prefix'    => 'plugin/product_review',
        'namespace' => '\App\Plugins\Cms\ProductReview\Controllers',
    ],
    function () {
        Route::post('post-review', 'FrontController@postReview')
        ->name('product_review.postReview');
        Route::post('remove-review', 'FrontController@removeReview')
        ->name('product_review.removeReview');
    }
);

