<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TestTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return $data->toArray();
    }
}
