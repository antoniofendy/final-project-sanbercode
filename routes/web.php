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

    //route untuk list pertanyaan user
    Route::get('/pertanyaan/{user_id}', 'UserController@list_pertanyaan');

    //route untuk vote tanya
    Route::get('user/vote-tanya/{pertanyaan_id}/{user_id}/{vote}', 'UserController@vote_tanya');

    //route untuk vote jawab
    Route::get('user/vote-jawab/{jawaban_id}/{user_id}/{vote}', 'UserController@vote_jawab');

    //route untuk detail
    Route::get('pertanyaan/{pertanyaan_id}/detail', 'ForumController@index');

    //route untuk jawab pertanyaan
    Route::get('/jawab/{pertanyaan_id}', 'ForumController@jawab');
    Route::post('/jawab', 'ForumController@jawabcreate');
});

Route::get('/user/komentar/comment', 'UserController@buat_komen');
Route::get('/user/komentar/hal', 'UserController@buat_komen1');


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
