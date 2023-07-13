<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContact extends Mailable
{
    use Queueable, SerializesModels;

    // private $otp;
    public $subject;
    public $contactMessage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subject, string $contactMessage)
    {
        $this->subject = $subject;
        $this->contactMessage = $contactMessage;
    }

  

    public function build()
    {
        return $this->view('emails.contact-mail')
                    ->subject($this->subject)
                    ->with([
                        'contactMessage' => $this->contactMessage
                    ]);
    }
    
}
