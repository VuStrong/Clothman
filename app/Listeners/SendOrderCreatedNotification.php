<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreated as MailOrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedNotification implements ShouldQueue
{
    public string $connection = 'database';

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
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        Mail::to($event->order->email)->queue(new MailOrderCreated($event->order));
    }
}
