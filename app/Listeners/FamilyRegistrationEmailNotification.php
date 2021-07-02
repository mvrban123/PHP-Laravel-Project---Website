<?php

namespace App\Listeners;

use App\Events\FamilyRegistrationRequest;

class FamilyRegistrationEmailNotification
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
     * @param  FamilyRegistrationRequest  $event
     * @return void
     */
    public function handle(FamilyRegistrationRequest $event)
    {
        var_dump($event->familyData);
        mail(
            $event->familyData['rod1']['email'],
            "Obitelji 3 Plus - Registracija obitelji",
            "Pozdrav! Hvala na registraciji! Vaš O3P."
        );

        if(!empty($event->familyData['rod2']))
        {
            mail(
                $event->familyData['rod2']['email'],
                "Obitelji 3 Plus - Registracija obitelji",
                "Pozdrav! Hvala na registraciji! Vaš O3P."
            );
        }

    }
}
