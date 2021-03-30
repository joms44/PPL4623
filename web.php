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
//Login
Route::get('/','Auth\AuthController@index');
Route::post('login','Auth\AuthController@login');


Route::group(['middleware'=>'is_login_middleware'],function(){
    Route::get('dashboard', 'TiketController@index');
    Route::get('depo', function () {return view('depo');});
    Route::get('lokasi',function() {return view('lokasi');});
    Route::get('pembayaran','PembayaranController@data');
    Route::post('pembayaran/create','PembayaranController@create');
    Route::post('pembayaran/activity','PembayaranController@activity');
    Route::get('tiket/{id}','TiketController@data');
    Route::post('tiket/harga','TiketController@harga');
    Route::delete('pembayaran/{id}', 'PembayaranController@destroy');
    Route::patch('pembayaran/edit/{id}', 'PembayaranController@update');
    Route::get('pembayaran/total','PembayaranController@total_pembayaran');   
    Route::get('pembayaran/print', 'PembayaranController@print');  
    Route::get('pembayaran/print_con', 'PembayaranController@print_con'); 
    Route::get('lokasidata','LokasiController@data');
    Route::get('logout','Auth\AuthController@logout');
    Route::get('lock','Auth\AuthController@lock');
    Route::post('open_lock','Auth\AuthController@open_lock');
    Route::get('set_session','LokasiController@set_session');
});






