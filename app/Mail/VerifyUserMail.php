<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Mail\Mailables\Attachment;

class VerifyUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $name;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($title, $name, $token)
    {
        $this->title = $title;
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
            // from: 'noreply@example.com',
            // cc: ['manager@rs-petrokimia.co.id'],
            // bcc: ['admin@rs-petrokimia.co.id']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify',
            with: [
                'name' => $this->name,
                'token' => $this->token,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // return [
        //     Attachment::fromPath(storage_path('app/files/document.pdf'))
        //         ->as('verification-document.pdf')
        //         ->withMime('application/pdf'),
        // ];
        return [];
    }
}
