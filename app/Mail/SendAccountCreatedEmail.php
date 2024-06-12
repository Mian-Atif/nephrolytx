<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class SendAccountCreatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $user;
    public $password;


    public function __construct($user, $password)
    {

        $this->user = $user;
        $this->password = $password;


    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = Password::broker()->createToken($this->user);
        return $this->view('emails.new-account-created', [
            'user' => $this->user,
            'token' => $token,
        ])->subject("Your Account has successfully been created on ".app_name())->replyTo('info@nephrolytx.com');
    }
}
