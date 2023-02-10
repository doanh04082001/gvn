<?php

namespace App\Jobs;

use App\Mail\ClientContactMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

/**
 * @var string
 */
    private $contactConfigEmail;

    /**
     * @var array
     */
    private $mailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contactConfigEmail, $mailData)
    {
        $this->contactConfigEmail = $contactConfigEmail;

        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->contactConfigEmail)->send(new ClientContactMail($this->mailData));
    }
}
