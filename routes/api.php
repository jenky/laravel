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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::api('v1', function ($router) {
    $router->get('/', function () {
        return response()->internalError();
    });

    $router->get('transformer', 'TestController@transformer');
    $router->get('validate', 'TestController@validation');
    $router->get('users', 'TestController@users');

    $router->get('auth', function (\Tymon\JWTAuth\JWTAuth $auth) {
        $user = \App\User::first();
        $token = $auth->fromUser($user);

        return compact('token');
    });

    $router->get('user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');
});
