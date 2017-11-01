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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/deposit', 'HomeController@showDeposit')->name('showDeposit');
Route::get('/withdrawal', 'HomeController@showWithdrawal')->name('showWithdrawal');
Route::get('/transfer', 'HomeController@showTransfer')->name('showTransfer');
Route::get('/transactions', 'HomeController@showTransactions')->name('showTransactions');

Route::post('/deposit', 'TransactionController@deposit')->name('deposit');
Route::post('/withdrawal', 'TransactionController@withdraw')->name('withdrawal');
Route::post('/transfer', 'TransactionController@transfer')->name('transfer');