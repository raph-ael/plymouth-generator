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

Route::get('/', 'PlymouthController@index');
Route::post('/generate', 'PlymouthController@generate');
Route::get('/install/{id}', 'PlymouthController@install');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
