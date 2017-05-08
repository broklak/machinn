<?php

Route::get('resto/category/change-status/{id}/{status}', 'Resto\CategoryController@changeStatus')->name('category.change-status');
Route::get('resto/category/delete/{id}', 'Resto\CategoryController@softDelete')->name('category.delete');
Route::resource('resto/category', 'Resto\CategoryController');

Route::get('resto/item/change-status/{id}/{status}', 'Resto\ItemController@changeStatus')->name('item.change-status');
Route::get('resto/item/delete/{id}', 'Resto\ItemController@softDelete')->name('item.delete');
Route::get('resto/stock', 'Resto\ItemController@stock')->name('item.stock');
Route::resource('resto/item', 'Resto\ItemController');

Route::get('resto/table/delete/{id}', 'Resto\TableController@softDelete')->name('table.delete');
Route::resource('resto/table', 'Resto\TableController');

Route::resource('resto/tax', 'Resto\TaxPosController', ['as' => 'pos']);

Route::get('resto/pos/change-status/{id}/{status}', 'Resto\PosController@changeStatus')->name('resto.pos.change-status');
Route::get('resto/pos/set-delivery/{id}/{status}', 'Resto\PosController@setDelivery')->name('resto.pos.set-delivery');
Route::get('resto/pos/print-receipt/{id}', 'Resto\PosController@printReceipt')->name('resto.pos.print-receipt');
Route::get('resto/active', 'Resto\PosController@activeOrder')->name('resto.pos.active');
Route::resource('resto/pos', 'Resto\PosController', ['as' => 'resto']);

Route::get('resto/report/sales', 'Resto\ReportController@sales')->name('resto.report-sales');
Route::get('resto/report/item', 'Resto\ReportController@item')->name('resto.report-item');