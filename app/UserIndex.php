<?php

namespace App;

use Jenky\ScoutElasticsearch\Elasticsearch\Index;

class UserIndex extends Index
{
    /**
     * Get all mapping properties.
     *
     * @return array
     */
    public function properties(): array
    {
        return $this->generateProperties([
            'name' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                ],
            ],
            'email' => [
                'type' => 'text',
                'fields' => [
                    'raw' => [
                        'type' => 'keyword',
                    ],
                ],
            ],
            'email_verified_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ],
        ]);
    }
}
