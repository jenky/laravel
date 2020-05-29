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
    dd(\App\Elasticsearch\UserIndex::queryString(request('q', '*'))
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
        ->queryString(request('q', '*'))
        ->sum('id')
        ->average('id')
        ->min('id')
        ->max('id')
        ->get()
        // ->exists('name')
    );
});

Route::get('global', function () {
    dd(\Jenky\Elastify\Search::with('.users', '.telescope')
        ->queryString(request('q', '*'))
        ->get()
    );
});

Route::get('test', function () {
    return App\UserIndex::make()->getConnection()
        ->indices()->getAliases([
            'index' => 'users-2019.01.29',
        ]);
});
