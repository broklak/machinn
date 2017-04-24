<?php
/**
 * Created by PhpStorm.
 * User: satrya
 * Date: 4/22/17
 * Time: 7:19 PM
 */
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