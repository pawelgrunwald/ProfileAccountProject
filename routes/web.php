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


Route::get('/edit', 'UserController@updateData');

Route::post('/edit', 'UserController@storeDetailData');

Route::get('/edit/profile-picture', 'UserController@updateProfileImage');

Route::post('/edit/profile-picture', 'UserController@storeProfileImage');


Route::get('/add-album', 'UserPhotoController@addAlbum');

Route::post('/add-album', 'UserPhotoController@storeAlbum');

Route::get('/delete-album/{id}', 'UserPhotoController@deleteAlbum');


Route::get('/add-photo', 'UserPhotoController@addPhoto');

Route::post('/add-photo', 'UserPhotoController@storePhotos');

Route::get('/delete-photo/{id}', 'UserPhotoController@deletePhoto');


Route::get('/post/{post_id}/set-active', 'PostController@setActive');

Route::get('/post/{post_id}/edit', 'PostController@updatePost');

Route::post('/post/edit', 'PostController@storePostData');

Route::get('/post/{post_id}/delete', 'PostController@deletePost');


Auth::routes();
