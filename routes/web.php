<?php

use Illuminate\Support\Facades\Route;
use Jenky\Songbird\Component;
use Jenky\Songbird\Contracts\Resolvable;
use Jenky\Songbird\Fields\Button;
use Jenky\Songbird\Fields\Checkbox;
use Jenky\Songbird\Fields\Text;

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
    // return view('welcome');
    return collect([
        Component::make('img')->src('https://vueformulate.com/assets/img/logo.png'),
        Text::make('E-mail Address', 'email')->placeholder('Please enter your email address'),
        Checkbox::make('Accept TOS', 'terms'),
        Button::make('Submit')->asSubmit(),
    ])
        ->when(function ($collection) {
            return $collection->whereInstanceOf(Resolvable::class)->each->resolve([]);
        })
        ->map->toArray()->pluck('props')->all();
});
