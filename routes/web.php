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

// Route::get('/', 'HomeController@start');

Route::get('/', function () {
   // return view('welcome');
   return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/articles', 'ArticlesController@index');
Route::post('/articles', 'ArticlesController@store')->middleware('auth');
Route::get('/articles/create', 'ArticlesController@create')->middleware('auth');
Route::get('/articles/{article}', 'ArticlesController@show');
Route::get('/articles/{article}/edit', 'ArticlesController@edit')->middleware('auth');
Route::put('/articles/{article}', 'ArticlesController@update')->middleware('auth');
Route::delete('/articles/{article}', 'ArticlesController@destroy')->middleware('auth');

Route::post('/comments/{article}', 'CommentController@store')->middleware('auth');
Route::get('/comments/{comment}/edit', 'CommentController@edit')->middleware('auth');
Route::put('/comments/{comment}', 'CommentController@update')->middleware('auth');
Route::delete('/comments/{comment}', 'CommentController@destroy')->middleware('auth');
