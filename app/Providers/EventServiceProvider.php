<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\Events\QueueBusy;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Notifications\QueueHasLongWaitTime;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //

        Event::listen(function (QueueBusy $event) {
            Notification::route('mail', 'dev@example.com')
                    ->notify(new QueueHasLongWaitTime(
                        $event->connection,
                        $event->queue,
                        $event->size
                    ));
        });
    }
}
