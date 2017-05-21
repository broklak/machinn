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
Route::get('back/report/arrival', 'Front\ReportController@arrival')->name("back.report.arrival");
Route::get('back/report/occupied', 'Front\ReportController@occupied')->name("back.report.occupied");
Route::get('back/report/outstanding', 'Front\ReportController@outstanding')->name("back.report.outstanding");
Route::get('back/report/void', 'Front\ReportController@void')->name("back.report.void");

Route::get('back/audit/room', 'Back\AuditController@room')->name("back.night.room");
Route::get('back/audit/room/void/{id}', 'Back\AuditController@voidRoom')->name("back.night.room.void");
Route::post('back/audit/room', 'Back\AuditController@processRoom')->name("back.night.room.process");

Route::get('back/audit/outlet', 'Back\AuditController@outlet')->name("back.night.outlet");
Route::get('back/audit/outlet/void/{id}', 'Back\AuditController@voidOutlet')->name("back.night.outlet.void");
Route::post('back/audit/outlet', 'Back\AuditController@processOutlet')->name("back.night.outlet.process");

Route::get('back/invoice/delete/{id}', 'Back\InvoiceController@softDelete')->name('invoice.delete');
Route::get('back/invoice/change-status/{id}/{status}', 'Back\InvoiceController@changeStatus')->name('invoice.change-status');
Route::resource('back/invoice', 'Back\InvoiceController');

Route::get('back/mutation/delete/{id}', 'Back\MutationController@softDelete')->name('mutation.delete');
Route::get('back/mutation/change-status/{id}/{status}', 'Back\MutationController@changeStatus')->name('mutation.change-status');
Route::resource('back/mutation', 'Back\MutationController');

Route::get('back/back-income/delete/{id}', 'Back\BackIncomeController@softDelete')->name('back-income.delete');
Route::get('back/back-income/change-status/{id}/{status}', 'Back\BackIncomeController@changeStatus')->name('back-income.change-status');
Route::resource('back/back-income', 'Back\BackIncomeController');

Route::get('back/invoice-payment/delete/{id}', 'Back\InvoicePaymentController@softDelete')->name('invoice-payment.delete');
Route::get('back/invoice-payment/change-status/{id}/{status}', 'Back\InvoicePaymentController@changeStatus')->name('invoice-payment.change-status');
Route::resource('back/invoice-payment', 'Back\InvoicePaymentController');

Route::get('back/transaction/delete/{id}', 'Front\TransactionController@softDelete')->name('back.transaction.delete');
Route::get('back/transaction/change-status/{id}/{status}', 'Front\TransactionController@changeStatus')->name('back.transaction.change-status');
Route::resource('back/transaction', 'Front\TransactionController', ['as' => 'back']);

Route::get('back/report/cash', 'Back\ReportController@cash')->name("back.report.cash");
Route::get('back/report/profit', 'Back\ReportController@profit')->name("back.report.profit");
Route::get('back/report/expense', 'Back\ReportController@expense')->name("back.report.expense");
Route::get('back/report/asset', 'Back\ReportController@asset')->name("back.report.asset");
Route::get('back/report/trial', 'Back\ReportController@asset')->name("back.report.trial");

Route::get('back/dashboard', 'Back\DashboardController@index')->name("back.dashboard");
Route::resource('back/account-receivable', 'Back\AccountReceivableController');