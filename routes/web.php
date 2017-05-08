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
Route::get('/', 'Master\RoomNumberController@viewRoom');
Route::get('home', 'Master\RoomNumberController@viewRoom');



Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
