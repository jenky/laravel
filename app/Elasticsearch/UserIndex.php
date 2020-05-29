<?php

namespace App\Elasticsearch;

use Jenky\Elastify\Index;

class UserIndex extends Index
{
    public function searchableAs(): string
    {
        return $this->name().'*';
    }
}
