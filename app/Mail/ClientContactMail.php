<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('web.contact.new_contact_mail_subject', ['app_name' => config('app.name')]))
            ->markdown('mails.contact_mail', ['mailData' => $this->mailData]);
    }
}
