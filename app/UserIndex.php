<?php

namespace App;

use Jenky\Elastify\Storage\Index;

class UserIndex extends Index
{
    public function searchableAs(): string
    {
        return $this->name().'*';
    }
}
