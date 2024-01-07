<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::prefix('account')->group(function () {
    Route::get('profile', 'AccountController@profile')->name('account.profile');
    Route::post('profile/updateFoto', 'AccountController@updateFoto')->name('account.updateFoto');

    Route::get('password', 'AccountController@password')->name('account.password');
    Route::patch('password', 'AccountController@updatePassword')->name('account.password');
});


/* MASTER PEGAWAI */
Route::namespace('Master')->middleware(['auth', 'permission:master-pegawai'])->group(function () {
    Route::get('pegawai/api', 'PegawaiController@api')->name('pegawai.api');
    Route::resource('pegawai', 'PegawaiController');

    Route::resource('user', 'UserController');

    Route::get('api/user', 'UserController@api')->name('api.user');

    Route::get('user/{pegawai_id}/add_user', 'UserController@add_user')->name('user.add_user');

    Route::get('user/{id}/getRoles', 'UserController@getRoles')->name('user.getRoles');

    Route::delete('user/{name}/destroyRole', 'UserController@destroyRole')->name('user.destroyRole');
});

/* MASTER ROLE */
Route::namespace('Master')->middleware(['auth', 'permission:master-role'])->group(function () {
    Route::resource('role', 'RoleController');

    Route::get('api/role', 'RoleController@api')->name('api.role');

    Route::get('role/{id}/permissions', 'RoleController@permissions')->name('role.permissions');

    Route::post('role/storePermissions', 'RoleController@storePermissions')->name('role.storePermissions');

    Route::get('role/{id}/getPermissions', 'RoleController@getPermissions')->name('role.getPermissions');
    Route::delete('role/{name}/destroyPermission', 'RoleController@destroyPermission')->name('role.destroyPermission');

    Route::resource('permission', 'PermissionController');
    Route::get('api/permission', 'PermissionController@api')->name('api.permission');
});
