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

Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group([
        'as'      => 'bank.',
        'prefix'  => 'bank'
    ], function () {
        Route::resource('lists', 'BankController');
        Route::resource('trans', 'BankTransController');
        Route::resource('users', 'BankUsersController');
        Route::resource('accounts', 'BankAccountsController');
        Route::resource('logs', 'BankLogController')->only('index', 'show', 'destroy');

        Route::group([
        'as'      => 'users.',
        'prefix'  => 'users/{user}'
        ], function () {
            Route::post('get-bank', 'BankUsersController@get_bank')->name('getBank');
        });
    });
});