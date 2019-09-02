<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProfileReviewedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $receiver;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $receiver, $link)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.reviewLeft');

        $this->subject($this->sender . ' has left a review on your profile.');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                    ->addTextHeader('x-mailgun-native-send', 'true');
        });
    }
}
