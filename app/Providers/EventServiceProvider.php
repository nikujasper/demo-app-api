<?php

namespace App\Providers;

use App\Jobs\ProcessPodcast;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        // $this->app->bind(
        //     ProcessPodcast::class . '@handle', //whenever ask for testjob@handle (instance of class and event), return the callback function
        //     fn ($job) => $job->handle()
        // );
    }
}
