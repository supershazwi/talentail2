<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProjectReviewedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $creator;
    public $project;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate, $creator, $project, $link)
    {
        $this->candidate = $candidate;
        $this->creator = $creator;
        $this->project = $project;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.projectSubmitted');

        $this->subject($this->creator . ' has reviewed project: ' . $this->project . '.');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                    ->addTextHeader('x-mailgun-native-send', 'true');
        });
    }
}
