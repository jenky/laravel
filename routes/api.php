<?php

use Illuminate\Http\Request;

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

Route::api('1.0', '1.2')
    ->group(function () {
        Route::get('/', function () {
            return [
                'message' => 'Welcome to Laravel',
            ];
        });
        Route::prefix('v1')->group(function () {
            Route::get('/', function () {
                return [
                    'version' => request()->version('^1.0 || ^2.0'),
                ];
            });
        });
    });
