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

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('users', 'App\Http\Controllers\UserController');
Route::resource('books', 'App\Http\Controllers\BookController');

// Route For Borrow
Route::get('borrow', 'App\Http\Controllers\BorrowController@index')->name('borrow');
Route::get('borrow/create', 'App\Http\Controllers\BorrowController@create')->name('borrowCreate');
Route::get('borrow/filter', 'App\Http\Controllers\BorrowController@filter')->name('filterBorrow');
Route::post('borrow/createData', 'App\Http\Controllers\BorrowController@store')->name('borrowCreateData');
Route::get('borrow/edit/{id}', 'App\Http\Controllers\BorrowController@edit')->name('editBorrow');
Route::patch('borrow/update/{id}', 'App\Http\Controllers\BorrowController@update')->name('updateBorrow');
