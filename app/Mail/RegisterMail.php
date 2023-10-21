<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $userVerification;

    public function __construct($user, $userVerification)
    {
        $this->user = $user;
        $this->userVerification = $userVerification;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))->view('Mail/register_mail')->with([
            'user' => $this->user,
            'userVerification' => $this->userVerification
        ]);
    }
}