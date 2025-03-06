<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $details;

    /**
     * Create a new message instance.
     */
    public function __construct($status, $details)
    {
        $this->status = $status;
        $this->details = $details;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Stock Application Status Update')
                    ->view('emails.application_status');
    }
}