<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.verifyUser');

        $this->subject('Hi ' . $this->user['name'] . ', please verify your email.');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                    ->addTextHeader('x-mailgun-native-send', 'true');
        });
        // return $this->subject('Hi ' . $this->user['name'] . ', please verify your email.')->view('emails.verifyUser');
    }
}
