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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'ParkingsController@index')->name('home');
Route::post('/list', 'ParkingsController@all')->name('list');

Route::get('/edit/{id}', 'ParkingsController@edit')->name('edit');
Route::post('/store', 'ParkingsController@store')->name('data.store');
Route::post('/update/{id}', 'ParkingsController@update')->name('data.update');
Route::get('/export', 'ParkingsController@exportPdf')->name('export');
Route::get('/delete/{id}', 'ParkingsController@destroy')->name('delete');