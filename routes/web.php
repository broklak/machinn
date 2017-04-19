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

Route::get('housekeep/lost/delete/{id}', 'HouseKeep\LostController@softDelete')->name('lost.delete');
Route::get('housekeep/lost/change-status/{id}/{status}', 'HouseKeep\LostController@changeStatus')->name('lost.change-status');
Route::resource('housekeep/lost', 'HouseKeep\LostController');

Route::get('housekeep/found/delete/{id}', 'HouseKeep\FoundController@softDelete')->name('found.delete');
Route::get('housekeep/found/change-status/{id}/{status}', 'HouseKeep\FoundController@changeStatus')->name('found.change-status');
Route::resource('housekeep/found', 'HouseKeep\FoundController');

Route::get('housekeep/damage/delete/{id}', 'HouseKeep\DamageController@softDelete')->name('damage.delete');
Route::get('housekeep/damage/change-status/{id}/{status}', 'HouseKeep\DamageController@changeStatus')->name('damage.change-status');
Route::resource('housekeep/damage', 'HouseKeep\DamageController');

Route::get('housekeep/house/dashboard', 'Master\RoomNumberController@houseKeep')->name('house.dashboard');
Route::get('housekeep/house/set/{id}/{status}', 'Master\RoomNumberController@changeHkStatus')->name('house.set');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
