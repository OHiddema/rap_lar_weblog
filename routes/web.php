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

Route::resource('articles', ArticlesController::class);
Route::get('/search', 'ArticlesController@search');

// afwijkende route dus recourcefull routing niet mogelijk
Route::get('/comments', 'CommentController@index');
Route::post('/comments/{article}', 'CommentController@store');
Route::get('/comments/{comment}/edit', 'CommentController@edit');
Route::put('/comments/{comment}', 'CommentController@update');
Route::delete('/comments/{comment}', 'CommentController@destroy');

Route::get('/dashboard', 'DashboardController@index');

Route::resource('dashboard/users', UsersController::class);

Route::post('/likes/{article}', 'LikeController@store');
Route::delete('/likes/{article}', 'LikeController@destroy');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');