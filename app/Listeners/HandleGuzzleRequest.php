<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Jenky\Guzzilla\Events\RequestHandled;

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
     * @param  \Jenky\Guzzilla\Events\RequestHandled  $event
     * @return void
     */
    public function handle(RequestHandled $event)
    {
        logger('Guzzle request and response', [
            'request' => $event->request,
            'response' => $event->response,
        ]);
    }
}
