<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEndorsersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $role;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($candidate, $role, $link)
    {
        $this->candidate = $candidate;
        $this->role = $role;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('emails.requestEndorsement');

        $this->subject($this->candidate . ' has requested your endorsement.');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                    ->addTextHeader('x-mailgun-native-send', 'true');
        });
    }
}
