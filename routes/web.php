<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Jenky\Transmit\Contracts\HttpClient;

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

Route::get('test', function (HttpClient $client) {
    // return guzzle()->get('https://jsonplaceholder.typicode.com/users/1', [
    $response = $client->get('https://httpbin.org/headers');

    // dd($response);
    return $response->json();
});
