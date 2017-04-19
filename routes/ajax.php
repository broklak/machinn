<?php
/**
 * Created by PhpStorm.
 * User: satrya
 * Date: 4/14/17
 * Time: 4:44 PM
 */

Route::get('ajax/searchProvince', 'Front\AjaxController@searchProvince')->name("ajax.searchProvince");
Route::get('ajax/searchProvince', 'Front\AjaxController@searchProvince')->name("ajax.searchProvince");
Route::get('ajax/searchRoom', 'Front\AjaxController@searchRoom')->name("ajax.searchRoom");
Route::get('ajax/getLogbook', 'Front\AjaxController@getLookBook')->name("ajax.getLogbook");
Route::post('ajax/searchItem', 'Front\AjaxController@searchItem')->name("ajax.searchItem");
Route::get('ajax/getTotalRoomRates', 'Front\AjaxController@getTotalRoomRates')->name("ajax.getTotalRoomRates");
Route::post('ajax/searchGuest', 'Front\AjaxController@searchGuest')->name("ajax.searchGuest");
Route::post('ajax/searchEmployee', 'Front\AjaxController@searchEmployee')->name("ajax.searchEmployee");