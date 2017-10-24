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
    return view('welcome');
});

Route::prefix('test')
    ->group(function () {
        Route::get('users', 'TestController@users');
        Route::get('transformer', 'TestController@transformer');
        Route::get('request', 'TestController@request');
        Route::get('controller', 'TestController@controller');
    });
