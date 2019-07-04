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
    dd( \App\UserIndex::queryString(request('q', '*'))
        ->highlight(['name' => []])
        ->sum('id')
        ->average('id')
        ->min('id')
        ->max('id')
        ->suggest(function ($q) {
            $q->term('name_suggest', 'name');
        })
        // ->toDSL()
        // ->take(30)->get()
        ->paginate(request('limit', 20))
        ->raw()
        // ->toArray()
    );
});

Route::get('facade', function () {
    dd( \Jenky\Elastify\Facades\ES::index('.users')
        ->match('name', 'Mr')
        ->sum('id')
        ->average('id')
        ->min('id')
        ->max('id')
        ->get()
        // ->exists('name')
    );
});
