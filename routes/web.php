<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'HomeController@index')->name('home.admin');
Route::get('/topup', 'TransactionController@topup')->name('topup');
Route::get('/withdraw', 'TransactionController@withdraw')->name('withdraw');
Route::post('/withdraw', 'TransactionController@store_withdraw')->name('withdraw.store');
Route::post('/topup', 'TransactionController@store_balance')->name('topup.store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
