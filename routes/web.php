<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('msg', function () {
    return view('index');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * -------------- MENU -----------------
 */
Route::get('/menus/table', 'MenuController@table')->name('menus.table');
Route::get('/menus/parentList', 'MenuController@parentList')->name('menus.parentList');
Route::post('/menus/up', 'MenuController@moveUp')->name('menus.moveUp');
Route::post('/menus/down', 'MenuController@moveDown')->name('menus.moveDown');
Route::resource('menus', 'MenuController');

/**
 * -------------- USERS -----------------
 */
Route::get('/users/table', 'UserController@table')->name('users.table');
Route::resource('users', 'UserController');


/**
 * -------------- ROLES -----------------
 */
Route::get('/authRoles/table', 'AuthRoleController@table')->name('authRoles.table');
Route::resource('authRoles', 'AuthRoleController');