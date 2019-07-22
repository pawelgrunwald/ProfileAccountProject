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

Route::get('/', function () {
    if (isset(Auth::user()->id)) {
        return redirect('home');
    } else {
        return view('welcome');
    }
})->name('start');

Route::get('/home', 'PostController@index');

Route::post('/', 'PostController@storePost');

Route::get('/profile', 'UserController@userTable');

Route::get('/post/{post_id}/setActive', 'PostController@setActive');

Route::get('/post/{post_id}/delete', 'PostController@deletePost');

Auth::routes();

