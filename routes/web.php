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

use Jenky\Hermes\JsonResponse;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    // dd(guzzle()->get('https://example.com'));
    // return guzzle()->get('https://jsonplaceholder.typicode.com/users/1', [
    $response = guzzle()->get('https://httpbin.org/json', [
        'response_handler' => JsonResponse::class,
    ]);

    dd($response);
});
