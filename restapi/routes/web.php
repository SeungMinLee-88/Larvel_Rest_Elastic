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
Route::get('/index', [
    'uses' => 'ExtReserveController@index'
])->name('index');
Route::post('/sessionstore', [
    'uses' => 'ExtReserveController@sessionstore'
])->name('sessionstore');

Route::get('/board', [
    'uses' => 'ExtBoardController@index'
])->name('board');
