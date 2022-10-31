<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HTTP Clients
    |--------------------------------------------------------------------------
    |
    | Here you may configure the HTTP clients for your application.
    | In addition, you may set any custom options as needed by the particular
    | client you choose.
    |
    */

    'clients' => [

        'default' => [
            'options' => [
                //
            ],
            'tap' => [

            ],
        ],

        'httpbin' => [
            'scope' => 'https://httpbin\.org',
            'options' => [
                'base_uri' => 'https://httpbin.org',
                'headers' => [
                    'X-Foo' => 'bar',
                ]
            ],
        ],
    ],

];
