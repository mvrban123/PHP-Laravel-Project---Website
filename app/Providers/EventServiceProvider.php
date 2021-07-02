<?php
/* READ: https://laravel.com/docs/8.x/events#registering-events-and-listeners */

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Events\FamilyRegistrationRequest;
use App\Listeners\FamilyRegistrationEmailNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ]

        FamilyRegistrationRequest::class => [
            FamilyRegistrationEmailNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
