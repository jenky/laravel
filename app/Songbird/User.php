<?php

namespace App\Songbird;

use Illuminate\Http\Request;
use Jenky\Songbird\Fields\Button;
use Jenky\Songbird\Fields\Checkbox;
use Jenky\Songbird\Fields\Password;
use Jenky\Songbird\Fields\Text;
use Jenky\Songbird\Resource;

class User extends Resource
{
    public static $model = \App\User::class;

    public static function routes($router)
    {
        parent::routes($router);

        $router->get('users/banned', 'App\Songbird\User@index')->name('users.banned');
    }

    public function fields(Request $request): array
    {
        return [
            Text::make('E-mail Address', 'email')
                ->placeholder('Please enter your email address')
                ->rules('required')
                ->sortable(),
            Password::make('Password')
                ->rules('required'),
            Checkbox::make('Accept TOS', 'terms')->onlyOnForms(),
            Button::make('Submit')->asSubmit()->onlyOnForms(),
        ];
    }

    public function allowedFilters(Request $request): array
    {
        return ['name'];
    }
}
