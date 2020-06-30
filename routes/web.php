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
    return view('welcome');
});

Route::get('/test', 'TestController@index');
Route::get('/test/fetch-data', 'TestController@fetch_data');
Route::post('/test/add-data', 'TestController@add_data')->name('test.add-data');
Route::post('/test/update-data', 'TestController@update_data')->name('test.update-data');
Route::post('/test/delete-data', 'TestController@delete_data')->name('test.delete-data');