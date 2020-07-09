<?php

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

use \App\Profile;
use \App\User;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route User
Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/pertanyaan/buat', 'UserController@buat_pertanyaan');
    Route::post('/user/pertanyaan/buat', 'UserController@simpan_pertanyaan');
});

Route::get('/user/komentar/comment', 'UserController@buat_komen');
Route::get('/user/komentar/hal', 'UserController@buat_komen1');


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
