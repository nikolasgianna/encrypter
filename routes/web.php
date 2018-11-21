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

Route::get('/encrypt_text', 'EncryptController@encrypt_text_view');
Route::post('/encrypt_text', 'EncryptController@upload');

Route::get('/encrypt_file', 'EncryptController@encrypt_file_view');
Route::post('/encrypt_file', 'EncryptController@upload');

Route::get('/decrypt_text', 'DecryptController@decrypt_text_view');
Route::post('/decrypt_text', 'DecryptController@upload');

Route::get('/decrypt_file', 'DecryptController@decrypt_file_view');
Route::post('/decrypt_file', 'DecryptController@upload');
