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

use Illuminate\Http\Request;

Route::post('/submit', function (Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'url' => 'required|url|max:255',
        'description' => 'required|max:255',
    ]);

    $link = tap(new App\Link($data))->save();

    return redirect('/');
});

Route::get('/', function () {
    //return view('welcome');

    $links = \App\Link::all();

    return view('welcome', ['links' => $links]);
});

Route::get('/submit', function () {
    return view('submit');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//
//
Route::get('/create', 'LinkController@create');
Route::post('/create', 'LinkController@store');
//
//
Route::get('/upload/index', 'FileUploadController@index')->name('upload.index');

Route::get('/encrypt', 'EncryptController@encrypt_view');
Route::post('/encrypt', 'EncryptController@upload');

Route::get('/decrypt', 'DecryptController@decrypt_view');
Route::post('/decrypt', 'DecryptController@upload');

Route::get('/upload', 'UploadController@create')->name('upload');
Route::post('/upload', 'UploadController@upload');
//
//
