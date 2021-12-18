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

    Route::get('/user/pertanyaan/buat', 'PertanyaanController@buat_pertanyaan');
    Route::post('/user/pertanyaan/buat', 'PertanyaanController@simpan_pertanyaan');

    // route untuk mencari topik forums
    Route::post('/search', 'HomeController@search');
    Route::get('/search/{keyword}', 'HomeController@searchpaginate');

    //route untuk list pertanyaan user
    Route::get('/pertanyaan/{user_id}', 'PertanyaanController@list_pertanyaan');

    //route untuk list jawaban user
    Route::get('/jawaban/{user_id}', 'JawabanController@list_jawaban');

    //route CRUD PERTANYAAN
    Route::get('/pertanyaan/{pertanyaan_id}/hapus', 'PertanyaanController@hapus_pertanyaan');
    Route::get('/pertanyaan/{pertanyaan_id}/edit', 'PertanyaanController@form_edit_pertanyaan');
    Route::post('/pertanyaan/{pertanyaan_id}/edit', 'PertanyaanController@store_edit_pertanyaan');

    //route untuk vote tanya
    Route::get('user/vote-tanya/{pertanyaan_id}/{user_id}/{vote}', 'UserController@vote_tanya');

    //route untuk vote jawab
    Route::get('user/vote-jawab/{jawaban_id}/{user_id}/{vote}', 'UserController@vote_jawab');

    //route untuk detail
    Route::get('pertanyaan/{pertanyaan_id}/detail', 'ForumController@index');

    //route untuk jawab pertanyaan
    Route::get('/jawab/{pertanyaan_id}', 'JawabanController@jawab');
    Route::post('/jawab', 'JawabanController@jawabcreate');

    //route untuk memilih jawaban tepat
    Route::get('/jawaban-tepat/{jawaban_id}', 'ForumController@jawab_tepat');

    //route untuk komentar pertanyaan
    Route::get('/komen-tanya/{pertanyaan_id}', 'ForumController@komen_tanya');
    Route::post('/komen-tanya', 'ForumController@komen_tanyacreate');

    //route untuk komentar jawaban
    Route::get('/komen-jawab/{pertanyaan_id}', 'ForumController@komen_jawab');
    Route::post('/komen-jawab', 'ForumController@komen_jawabcreate');

    //route untuk update jawaban
    Route::get('/edit-jawaban/{jawaban_id}', 'JawabanController@form_edit_jawaban');
    Route::post('/edit-jawaban/', 'JawabanController@update_jawaban');

    Route::get('/hapus-jawaban/{jawaban_id}', 'JawabanController@hapus_jawaban');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
