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

Route::get('search', function () {
    // return \App\UserIndex::find([1, 2, 3, 4]);
    return \App\UserIndex::match('name', 'Chasity')
        ->highlight(['name' => []])
        // ->toDSL();
        ->get(request('limit'));
});

Route::get('test', function () {
    dd( \Jenky\LaravelElasticsearch\Facades\ES::index('.users')
        ->match('name', 'Chasity')
        ->get()
        // ->exists('name')
    );
});
