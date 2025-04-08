<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailgeBrodcaster extends Mailable
{
    use Queueable, SerializesModels;

    
    public $brodcasMessage;
    public $email;
    /**
     * Create a new message instance.
     */
    public function __construct($brodcasMessage, $email)
    {
        $this->brodcasMessage = $brodcasMessage;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'kombolcha investment office',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $brodcasMessage = $this->brodcasMessage;
        $email = $this->email;
        return (new Content())->view('brodcast')->with( $email, $brodcasMessage);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
