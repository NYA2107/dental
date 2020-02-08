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
    return view('dashboard');
});

Route::get('/dokter/list', 'DokterController@list')->name('dokter-list');
Route::post('/dokter/store', 'DokterController@store')->name('dokter-store');
Route::post('/dokter/edit', 'DokterController@edit')->name('dokter-edit');
Route::post('/dokter/remove', 'DokterController@remove')->name('dokter-remove');

Route::get('/pasien/add', 'PasienController@add')->name('pasien-add');
Route::post('/pasien/store', 'PasienController@store')->name('pasien-store');
Route::get('/pasien/list', 'PasienController@list')->name('pasien-list');
Route::get('/pasien/search', 'PasienController@list')->name('pasien-search');