<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PasswordResetRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $emailData = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_data = [])
    {
        $this->emailData = $email_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        mail(
            $this->emailData['email'],
            "Obitelji 3 Plus - Promjena lozinke",
            "Pozdrav! Na slijedećoj poveznici možete promijeniti svoju lozinku: " . $this->emailData['url']
        );
    }
}
