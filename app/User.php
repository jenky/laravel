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
        return [
            $this->getKeyName() => [
                'type' => 'integer',
            ],
            'name' => [
                'type' => 'text',
            ],
            'email' => [
                'type' => 'text',
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
            'updated_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
        ];
    }
}
