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

Route::get('/', function () {
   // return view('welcome');
   return view('home');
});

Route::get('/home', 'HomeController@index')->name('home');

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

Route::get('/dashboard', 'DashboardController@index');

Route::get('/dashboard/users', 'UsersController@index');
Route::post('/dashboard/users', 'UsersController@store');
Route::get('/dashboard/users/{user}/edit', 'UsersController@edit');
Route::put('/dashboard/users/{user}', 'UsersController@update');
Route::delete('/dashboard/users/{user}', 'UsersController@destroy');

Route::post('/likes/{article}', 'LikeController@store')->middleware('auth');
Route::delete('/likes/{article}', 'LikeController@destroy')->middleware('auth');
