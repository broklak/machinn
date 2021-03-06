<?php
/**
 * Created by PhpStorm.
 * User: satrya
 * Date: 4/14/17
 * Time: 4:43 PM
 */

Route::get('front/guest/checkin-report', 'Front\GuestController@checkinReport')->name("guest.checkin");
Route::get('front/guest/statistic', 'Front\GuestController@statistic')->name("guest.statistic");
Route::get('front/guest/inhouse', 'Front\GuestController@inhouse')->name("guest.inhouse");
Route::get('front/guest/delete/{id}', 'Front\GuestController@softDelete')->name('guest.delete');
Route::resource('front/guest', 'Front\GuestController');
Route::resource('front/staff', 'Front\StaffController');

Route::get('front/checkin', 'Front\CheckinController@create')->name('checkin.index');
Route::get('front/checkin/detail/{bookingId}', 'Front\CheckinController@detail')->name('checkin.detail');
Route::post('front/checkin/extracharge/{bookingId}', 'Front\CheckinController@extracharge')->name('checkin.extracharge');
Route::post('front/checkin/rate/{bookingId}', 'Front\CheckinController@rate')->name('checkin.rate');
Route::post('front/checkin/room-edit/{bookingId}', 'Front\CheckinController@updateRoom')->name('checkin.room-edit');
Route::get('front/checkin/book/{bookingId}', 'Front\CheckinController@book')->name('checkin.book');
Route::get('front/checkin/payment/{bookingId}', 'Front\CheckinController@payment')->name('checkin.payment');
Route::get('front/checkin/checkout/{bookingId}', 'Front\CheckinController@checkout')->name('checkin.checkout');
Route::post('front/checkin/make-payment/{bookingId}', 'Front\CheckinController@makePayment')->name('checkin.make-payment');
Route::post('front/checkin', 'Front\CheckinController@store')->name('checkin.store');
Route::get('front/checkin/print-receipt/{bookingId}', 'Front\CheckinController@printReceipt')->name('checkin.print-receipt');
Route::get('front/checkin/print-bill/{bookingId}', 'Front\CheckinController@printBill')->name('checkin.print-bill');
Route::get('front/checkin/print-deposit/{bookingPaymentId}', 'Front\CheckinController@printDeposit')->name('checkin.print-deposit');
Route::post('front/checkin/void/{bookingId}', 'Front\CheckinController@deposit')->name("checkin.deposit");
Route::get('front/checkin/void-deposit/{bookingPaymentId}', 'Front\CheckinController@voidDeposit')->name("checkin.void-deposit");
Route::post('front/checkin/refund-deposit/{bookingPaymentId}', 'Front\CheckinController@refundDeposit')->name("checkin.refund-deposit");

Route::get('front/logbook/change-status/{id}/{status}', 'Master\LogbookController@changeStatus')->name('logbook.change-status');
Route::get('front/logbook/done/{id}', 'Master\LogbookController@done')->name('logbook.done');
Route::resource('front/logbook', 'Master\LogbookController');

Route::get('front/transaction/delete/{id}', 'Front\TransactionController@softDelete')->name('transaction.delete');
Route::get('front/transaction/change-status/{id}/{status}', 'Front\TransactionController@changeStatus')->name('transaction.change-status');
Route::resource('front/transaction', 'Front\TransactionController');

Route::get('front/pos/change-status/{id}/{status}', 'Front\PosController@changeStatus')->name('pos.change-status');
Route::resource('front/pos', 'Front\PosController');

Route::get('front/report/guest-bill', 'Front\ReportController@guestBill')->name("report.guest-bill");
Route::get('front/report/down-payment', 'Front\ReportController@downPayment')->name("report.down-payment");
Route::get('front/report/cash-credit', 'Front\ReportController@cashCredit')->name("report.cash-credit");
Route::get('front/report/front-pos', 'Front\ReportController@frontPos')->name("report.front-pos");
Route::get('front/report/source', 'Front\ReportController@source')->name("report.source");

Route::post('front/booking/void/{bookingId}', 'Front\BookingController@voidBooking')->name("booking.void");
Route::get('front/booking/report', 'Front\BookingController@report')->name("booking.report");
Route::get('front/booking/showdownpayment/{bookingId}', 'Front\BookingController@showDownPayment')->name("booking.showdownpayment");
Route::resource('front/booking', 'Front\BookingController');