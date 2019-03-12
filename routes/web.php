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
    dd( \App\UserIndex::queryString('*')
        ->highlight(['name' => []])
        ->sum('id')
        ->average('id')
        ->min('id')
        ->max('id')
        ->suggest(function ($q) {
            $q->term('name_sugges', 'name');
        })
        // ->toDSL()
        // ->take(30)->get()
        ->paginate(request('limit', 20))
        // ->raw()
        ->toArray()
    );
});

Route::get('test', function () {
    dd( \Jenky\Elastify\Facades\ES::index('.users')
        ->match('name', 'Chasity')
        ->get()
        // ->exists('name')
    );
});
