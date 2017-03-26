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
Route::get('/', 'Master\RoomNumberController@index');

Route::post('ajax/searchGuest', 'Front\AjaxController@searchGuest')->name("ajax.searchGuest");
Route::get('ajax/searchProvince', 'Front\AjaxController@searchProvince')->name("ajax.searchProvince");
Route::get('ajax/searchRoom', 'Front\AjaxController@searchRoom')->name("ajax.searchRoom");
Route::get('ajax/getTotalRoomRates', 'Front\AjaxController@getTotalRoomRates')->name("ajax.getTotalRoomRates");

Route::resource('front/booking', 'Front\BookingController');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
