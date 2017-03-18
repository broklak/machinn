<?php

Route::get('master/bank/change-status/{id}/{status}', 'Master\BankController@changeStatus')->name('bank.change-status');
Route::resource('master/bank', 'Master\BankController');

Route::get('master/banquet-event/change-status/{id}/{status}', 'Master\BanquetEventController@changeStatus')->name('banquet-event.change-status');
Route::resource('master/banquet-event', 'Master\BanquetEventController');

Route::get('master/banquet/change-status/{id}/{status}', 'Master\BanquetController@changeStatus')->name('banquet.change-status');
Route::resource('master/banquet', 'Master\BanquetController');

Route::get('master/cash-account/change-status/{id}/{status}', 'Master\CashAccountController@changeStatus')->name('cash-account.change-status');
Route::resource('master/cash-account', 'Master\CashAccountController');

Route::get('master/credit-card-type/change-status/{id}/{status}', 'Master\CreditCardTypeController@changeStatus')->name('credit-card-type.change-status');
Route::resource('master/credit-card-type', 'Master\CreditCardTypeController');

Route::get('master/cost/change-status/{id}/{status}', 'Master\CostController@changeStatus')->name('cost.change-status');
Route::resource('master/cost', 'Master\CostController');

Route::get('master/country/change-status/{id}/{status}', 'Master\CountryController@changeStatus')->name('country.change-status');
Route::resource('master/country', 'Master\CountryController');

Route::get('master/department/change-status/{id}/{status}', 'Master\DepartmentController@changeStatus')->name('department.change-status');
Route::resource('master/department', 'Master\DepartmentController');

Route::get('master/employee-shift/change-status/{id}/{status}', 'Master\EmployeeShiftController@changeStatus')->name('employee-shift.change-status');
Route::resource('master/employee-shift', 'Master\EmployeeShiftController');

Route::get('master/employee-status/change-status/{id}/{status}', 'Master\EmployeeStatusController@changeStatus')->name('employee-status.change-status');
Route::resource('master/employee-status', 'Master\EmployeeStatusController');

Route::get('master/employee-type/change-status/{id}/{status}', 'Master\EmployeeTypeController@changeStatus')->name('employee-type.change-status');
Route::resource('master/employee-type', 'Master\EmployeeTypeController');

Route::get('change-password', 'Master\EmployeeController@changePassword')->name('change-password');
Route::post('change-password', 'Master\EmployeeController@changePassword')->name('change-password');
Route::get('master/employee/change-status/{id}/{status}', 'Master\EmployeeController@changeStatus')->name('employee.change-status');
Route::resource('master/employee', 'Master\EmployeeController');

Route::get('master/extracharge-group/change-status/{id}/{status}', 'Master\ExtrachargeGroupController@changeStatus')->name('extracharge-group.change-status');
Route::resource('master/extracharge-group', 'Master\ExtrachargeGroupController');

Route::get('master/extracharge/change-status/{id}/{status}', 'Master\ExtrachargeController@changeStatus')->name('extracharge.change-status');
Route::resource('master/extracharge', 'Master\ExtrachargeController');

Route::get('master/income/change-status/{id}/{status}', 'Master\IncomeController@changeStatus')->name('income.change-status');
Route::resource('master/income', 'Master\IncomeController');

Route::get('master/partner-group/change-status/{id}/{status}', 'Master\PartnerGroupController@changeStatus')->name('partner-group.change-status');
Route::resource('master/partner-group', 'Master\PartnerGroupController');

Route::get('master/partner/change-status/{id}/{status}', 'Master\PartnerController@changeStatus')->name('partner.change-status');
Route::resource('master/partner', 'Master\PartnerController');

Route::get('master/property-attribute/change-status/{id}/{status}', 'Master\PropertyAttributeController@changeStatus')->name('property-attribute.change-status');
Route::resource('master/property-attribute', 'Master\PropertyAttributeController');

Route::get('master/property-floor/change-status/{id}/{status}', 'Master\PropertyFloorController@changeStatus')->name('property-floor.change-status');
Route::resource('master/property-floor', 'Master\PropertyFloorController');

Route::get('master/province/change-status/{id}/{status}', 'Master\ProvinceController@changeStatus')->name('province.change-status');
Route::resource('master/province', 'Master\ProvinceController');

Route::get('master/tax/change-status/{id}/{status}', 'Master\TaxController@changeStatus')->name('tax.change-status');
Route::resource('master/tax', 'Master\TaxController');

Route::get('master/settlement/change-status/{id}/{status}', 'Master\SettlementController@changeStatus')->name('settlement.change-status');
Route::resource('master/settlement', 'Master\SettlementController');

Route::get('master/room-attribute/change-status/{id}/{status}', 'Master\RoomAttributeController@changeStatus')->name('room-attribute.change-status');
Route::resource('master/room-attribute', 'Master\RoomAttributeController');

Route::get('master/room-rate-day-type/change-status/{id}/{status}', 'Master\RoomRateDayTypeController@changeStatus')->name('room-rate-day-type.change-status');
Route::resource('master/room-rate-day-type', 'Master\RoomRateDayTypeController');

Route::get('master/room-type/change-status/{id}/{status}', 'Master\RoomTypeController@changeStatus')->name('room-type.change-status');
Route::resource('master/room-type', 'Master\RoomTypeController');

Route::get('master/room-number/change-status/{id}/{status}', 'Master\RoomNumberController@changeStatus')->name('room-number.change-status');
Route::resource('master/room-number', 'Master\RoomNumberController');

Route::get('master/room-plan/change-status/{id}/{status}', 'Master\RoomPlanController@changeStatus')->name('room-plan.change-status');
Route::resource('master/room-plan', 'Master\RoomPlanController');