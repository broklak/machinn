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
Route::get('/', 'Master\BankController@index');

Route::resource('master/room-number', 'Master\RoomNumberController');

Route::get('master/bank/change-status/{id}/{status}', 'Master\BankController@changeStatus')->name('bank.change-status');
Route::resource('master/bank', 'Master\BankController');

Route::get('master/banquet-event/change-status/{id}/{status}', 'Master\BanquetEventController@changeStatus')->name('banquet-event.change-status');
Route::resource('master/banquet-event', 'Master\BanquetEventController');

Route::get('master/banquet/change-status/{id}/{status}', 'Master\BanquetController@changeStatus')->name('banquet.change-status');
Route::resource('master/banquet', 'Master\BanquetController');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
