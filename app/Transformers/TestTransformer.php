<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TestTransformer extends TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected $availableIncludes = [
        'foo',
    ];

    public function transform($data)
    {
        return $data->toArray();
    }

    public function includeFoo($data)
    {
        return null;
    }
}
