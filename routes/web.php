<?php

use App\Mail\TestEmail;
use Illuminate\Contracts\Mail\Mailer;

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

Route::get('log', function () {
    $message = request('log', 'This is a log message');
    logger($message);

    return $message;
});

Route::get('exception', function () {
    throw new \RuntimeException("Error Processing Request");
});

Route::get('mail', function (Mailer $mailer) {
    $mail = new TestEmail;
    $mailer->to('hello@example.com')
        ->send($mail);

    return $mail->render();
});
