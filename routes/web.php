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

Route::get('/', 'HomeController@index');

Auth::routes();


Route::get('/products', 'ProductController@index');
Route::post('/product', 'ProductController@store');
Route::put('/product/{id}', 'ProductController@update');
Route::get('/product/{id}', 'ProductController@show');
Route::delete('/product/{id}', 'ProductController@destroy');



