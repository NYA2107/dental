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
Route::post('/pasien/remove', 'PasienController@remove')->name('pasien-remove');
Route::post('/pasien/edit', 'PasienController@edit')->name('pasien-edit');
Route::get('/pasien/list', 'PasienController@list')->name('pasien-list');
Route::get('/pasien/search', 'PasienController@search')->name('pasien-search');
Route::get('/pasien/{id}', 'PasienController@detail')->name('pasien-detail');
Route::get('/pasien/{id}/kunjungan', 'PasienController@detailKunjunganSearch')->name('pasien-kunjungan-search');
Route::post('/pasien/upload', 'PasienController@upload')->name('pasien-upload');
Route::get('/pasien/file/{id}', 'PasienController@viewFile')->name('pasien-view-file');
Route::post('/pasien/remove/file', 'PasienController@removeFile')->name('pasien-remove-file');

Route::get('/kunjungan/list', 'KunjunganController@list')->name('kunjungan-list');
Route::get('/kunjungan/list/filter', 'KunjunganController@filter')->name('kunjungan-filter');
Route::post('/kunjungan/store', 'KunjunganController@store')->name('kunjungan-store');
Route::post('/kunjungan/remove', 'KunjunganController@remove')->name('kunjungan-remove');
Route::post('/kunjungan/edit', 'KunjunganController@edit')->name('kunjungan-edit');
Route::post('/kunjungan/excel', 'KunjunganController@exportExcel')->name('kunjungan-excel');
Route::post('/kunjungan/pdf', 'KunjunganController@exportPdf')->name('kunjungan-pdf');

Route::get('/antrian', 'AntrianController@index')->name('antrian');
Route::post('/antrian', 'AntrianController@getAntrian')->name('antrian-get-json');
Route::get('/antrian/add', 'AntrianController@addAntrian')->name('antrian-add-json');
Route::post('/antrian/set', 'AntrianController@setAntrian')->name('antrian-set-json');
