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

$p = 'App\\Http\\Controllers\\';

Route::get('/', $p.'HomeController@index');

Route::get('/articles', $p.'ArticlesController@index');
Route::post('/articles', $p.'ArticlesController@store');
Route::get('/articles/create', $p.'ArticlesController@create');
Route::get('/articles/{article}', $p.'ArticlesController@show');
Route::get('/articles/{article}/edit', $p.'ArticlesController@edit');
Route::put('/articles/{article}', $p.'ArticlesController@update');
