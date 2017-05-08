<?php

Route::get('back/guest/checkin-report', 'Front\GuestController@checkinReport')->name("back.guest.checkin");
Route::get('back/guest/statistic', 'Front\GuestController@statistic')->name("back.guest.statistic");
Route::get('back/guest/inhouse', 'Front\GuestController@inhouse')->name("back.guest.inhouse");
Route::get('back/guest/delete/{id}', 'Front\GuestController@softDelete')->name('back.guest.delete');
Route::resource('back/guest', 'Front\GuestController', ['as' => 'back']);

Route::get('back/report/sales', 'Resto\ReportController@sales')->name('back.report-sales');
Route::get('back/report/item', 'Resto\ReportController@item')->name('back.report-item');

Route::get('back/report/guest-bill', 'Front\ReportController@guestBill')->name("back.report.guest-bill");
Route::get('back/report/down-payment', 'Front\ReportController@downPayment')->name("back.report.down-payment");
Route::get('back/report/cash-credit', 'Front\ReportController@cashCredit')->name("back.report.cash-credit");
Route::get('back/report/front-pos', 'Front\ReportController@frontPos')->name("back.report.front-pos");
Route::get('back/report/source', 'Front\ReportController@source')->name("back.report.source");
Route::get('back/booking/report', 'Front\BookingController@report')->name("back.booking.report");

Route::get('back/dashboard', 'Back\DashboardController@index')->name("back.dashboard");