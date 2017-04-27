<?php

namespace App\Rules;

use Jenky\SmartRule\Rule;

class TestRule extends Rule
{
    public function rules()
    {
        return [
            'email' => 'email|min:3',
            'name' => 'min:3|max:100',
        ];
    }

    protected function collection()
    {
        $this->forget('email');
    }
}
