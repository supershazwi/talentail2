<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProjectPurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $creator;
    public $projects;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($creator, $projects, $link)
    {
        $this->creator = $creator;
        $this->projects = $projects;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.projectPurchased');

        $this->subject('Good news. Someone purchased your project(s).');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                    ->addTextHeader('x-mailgun-native-send', 'true');
        });
    }
}
