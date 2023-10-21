<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $resetPassword;

    public function __construct($user, $resetPassword)
    {
        $this->user = $user;
        $this->resetPassword = $resetPassword;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->view('mail/reset_password_mail')
            ->with([
                'user' => $this->user,
                'resetPassword' => $this->resetPassword
            ]);
    }
}