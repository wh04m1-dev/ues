<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SednMail extends Mailable
{
    use Queueable, SerializesModels;

    public $welcomeMessage;

    public function __construct($welcomeMessage)
    {
        $this->welcomeMessage = $welcomeMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sedn Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'SendEmail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
