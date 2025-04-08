<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnsewerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $answer;
    public $email;
    public $question;
    /**
     * Create a new message instance.
     */
    public function __construct($answer, $email, $question)
    {
        $this->answer = $answer;
        $this->email = $email;
        $this->question = $question;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'kmoblocha investment office answer your  question',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $email = $this->email;
        $question = $this->question;
        $answer = $this->answer;
        return (new Content())->view('answer')->with($email, $question, $answer);
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
