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

Route::resource('master/room-number', 'Master\RoomNumberController');

Route::get('master/bank/change-status/{id}/{status}', 'Master\BankController@changeStatus')->name('bank.change-status');
Route::resource('master/bank', 'Master\BankController');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'Master\RoomNumberController@index');
