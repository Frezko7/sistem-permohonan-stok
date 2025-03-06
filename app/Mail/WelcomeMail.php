<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Welcome to ' . config('app.name'))
                    ->view('emails.welcome');
    }
}
