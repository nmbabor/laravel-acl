<?php
//Route File one


Route::resource('company', 'CompanyListController')->middleware('permission:company');
Route::resource('company-branch', 'CompanyBranchController')->middleware('permission:branch');
/*  Employe */
Route::resource('employee-section', 'Hrm\EmployeeSectionController');
Route::resource('employees', 'Hrm\EmployeeController');
Route::get('export-employee', 'Hrm\EmployeeController@exportEmployee');
Route::get('export-attendance', 'Hrm\AttendanceController@exportAttendance');
Route::resource('attendance', 'Hrm\AttendanceController');
Route::get('attendance-all', 'Hrm\AttendanceController@all');
Route::post('attendance-import', 'Hrm\AttendanceController@importAttendance');
Route::get('employee-attendance', 'Hrm\EmployeeAttendanceController@index');
Route::get('employee-attendance/{id}', 'Hrm\EmployeeAttendanceController@view');
Route::get('load-employee/{id}', 'Hrm\EmployeeAttendanceController@loadEmployee');
Route::resource('leave', 'Hrm\LeaveRequestController');



