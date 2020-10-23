<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('v1', function () {
    return [
        'message' => 'Welcome to Laravel',
        'version' => [
            'set' => 'v1',
            'request' => request()->version(),
        ],
    ];
});

Route::get('v2', function () {
    return [
        'message' => 'Welcome to Laravel',
        'version' => [
            'set' => 'v2',
            'request' => request()->version(),
        ],
    ];
});

Route::get('exception', function () {
    throw new \Exception('Test exception');
});

Route::post('validation', function (Request $request) {
    $request->validate([
        'name' => 'required',
    ]);

    return [];
});
