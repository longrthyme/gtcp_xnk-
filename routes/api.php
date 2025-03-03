<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('bct/{year?}', 'Api\BCTController@index')->name('api.bct');
// Route::post('login-bao-cao-bct', 'Api\BCTController@loginBaocao')->name('api.bct_baocao_login');
// Route::get('bao-cao-bct', 'Api\BCTController@baocao')->name('api.bct_baocao');