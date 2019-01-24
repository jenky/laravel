<?php

namespace App;

use Jenky\LaravelElasticsearch\Storage\Index;

class UserIndex extends Index
{
    public function searchableAs(): string
    {
        return $this->name().'*';
    }
}
