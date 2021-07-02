<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Queue;

class AutoPorukaRegistracijaObiteljiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $AUTO_PORUKA_NAZIV = "uspjesna_registracija_obitelji";
    private $emaiFamilylData = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_data = [])
    {
        $this->emaiFamilylData = $email_data;
    }

    /**
     * Returns the number of minutes for which this job should be delayed.
     * 
     * @return int
     */
    public function getDelay()
    {
        return $this->delayInMinutes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        # TEST
        // mail(
        //     "vocalax774@combcub.com",
        //     "Obitelji 3 Plus - Registracija obitelji",
        //     "DOGODA 5 MINUTA! Pozdrav! Hvala na registraciji! Vaš O3P."
        // );

        mail(
            $this->emaiFamilylData['rod1']['email'],
            "Obitelji 3 Plus - Registracija obitelji",
            "Pozdrav! Hvala na registraciji! Vaš O3P."
        );

        if(!empty($this->emaiFamilylData['rod2']))
        {
            mail(
                $this->emaiFamilylData['rod2']['email'],
                "Obitelji 3 Plus - Registracija obitelji",
                "Pozdrav! Hvala na registraciji! Vaš O3P."
            );
        }
    }
}