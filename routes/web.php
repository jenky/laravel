<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jenky\Captcha\Validation\Captcha;

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

Route::view('captcha', 'captcha')->name('captcha');

Route::post('captcha', function (Request $request) {
    $request->validate([
        'h-captcha-response' => Captcha::required(),
    ]);

    return ['ok' => true];
});
