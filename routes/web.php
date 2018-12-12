<?php
Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('company-dashboard/{id}', 'HomeController@company');
    Route::get('custom-query', 'HomeController@query')->middleware('role:developer');
    Route::post('custom-query', 'HomeController@queryPost')->middleware('role:developer');
    Route::get('module-dashboard/{company_id}/{module_id}', 'HomeController@module');
    Route::get('sub-menu-load/{id}', 'HomeController@subMenu');
    Route::resource('primary-info', 'PrimaryInfoController')->middleware('permission:primary-info');
    Route::resource('/profile', 'ProfileController');
    Route::get('load-branch/{id?}', 'UsersController@loadBranch');
    Route::resource('/users', 'UsersController')->middleware('permission:user');
    Route::post('change-password',['as'=>'password','uses'=>'UsersController@password']);
    Route::get('change-password','UsersController@changePass')->middleware('permission:user');
    Route::resource('acl-permission', 'AclPermissionController')->middleware('role:developer');
    Route::resource('acl-role', 'AclRolesController')->middleware('permission:acl');
    Route::post('acl-permission-role', 'AclPermissionController@storeRole')->middleware('permission:acl');
    Route::resource('menu','MenuController')->middleware('permission:menu');
    Route::resource('sub-menu','SubMenuController')->middleware('permission:menu');
    Route::resource('sub-sub-menu','SubSubMenuController')->middleware('permission:menu');

    require_once ('routeFileOne.php');
    require_once ('routeFileTwo.php');
});


//Clear Cache facade value:
Route::get('/clear-cache','CacheClearController@clearCache');
//Clear View cache:
Route::get('/view-clear','CacheClearController@viewClear');

//Clear Route cache:
Route::get('/route-clear','CacheClearController@routeCache');
//Seeding
Route::get('/seeding','CacheClearController@seed');
//Migrate
Route::get('/migrate','CacheClearController@migrate');

// Wrong url redirect to dashboard page

Route::get('register', function () {
    return redirect('/');
});
/* Testing */
Route::get('receive-attendance', 'Hrm\AttendanceReciveController@getAttendance');
Route::post('receive-attendance', 'Hrm\AttendanceReciveController@postAttendance');
