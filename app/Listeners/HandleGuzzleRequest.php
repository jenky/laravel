<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jenky\Hermes\Events\RequestHandled;

class HandleGuzzleRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Jenky\Hermes\Events\RequestHandled  $event
     * @return void
     */
    public function handle(RequestHandled $event)
    {
        logger('Guzzle request and response', [
            'request' => (string) $event->request->getBody(),
            'response' => $event->response ? (string) $event->response->getBody() : null,
        ]);
    }
}
