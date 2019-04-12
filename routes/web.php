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
//SELECT * FROM `wl_steiges` INNER JOIN `wl_haltestellens` ON wl_haltestellens.HALTESTELLEN_ID = wl_steiges.HALSTESTELLEN_ID
Route::get('/', 'LinesController@home');
Route::get('/lines', 'LinesController@index');
