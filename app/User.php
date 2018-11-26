<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;
use Jenky\ScoutElasticsearch\ScoutElasticsearch;

class User extends Authenticatable
{
    use Notifiable, Searchable, ScoutElasticsearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getIndexProperties(): array
    {
        return array_merge([
            'name' => [
                'type' => 'text',
            ],
            'email' => [
                'type' => 'text',
            ],
            'email_verified_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
        ], $this->dynamicProperties());
    }
}
