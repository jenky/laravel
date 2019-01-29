<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenky\ScoutElasticsearch\ScoutElasticsearch;
use Laravel\Scout\Searchable;

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

    public function elasticsearchIndex()
    {
        return new UserIndex($this);
    }
}
