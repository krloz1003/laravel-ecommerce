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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([], function () {
    Route::post('/auth/login', 'AuthController@login');
    Route::post('/auth/signup', 'AuthController@signUp');

    Route::get('/products', 'ProductController@getData');
    Route::get('/product/{slug}', 'ProductController@show');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/auth/logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::put('/product/{id}', 'ProductController@update');
        Route::post('/product', 'ProductController@store');
        Route::delete('/product/{id}', 'ProductController@destroy');

        Route::get('/users', 'UserController@getData');
        Route::get('/user/{id}', 'UserController@show');
        Route::put('/user/{id}', 'UserController@update');
        Route::post('/user', 'UserController@store');
        Route::delete('/user/{id}', 'UserController@destroy');   

    });
});




