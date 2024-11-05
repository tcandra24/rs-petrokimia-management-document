<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class SendDispositionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $disposition;
    public $memo;
    public $view;
    public $note;
    public $files;

    /**
     * Create a new message instance.
     */
    public function __construct($content)
    {
        $this->title = $content['title'];
        $this->disposition = $content['disposition'];
        $this->memo = $content['memo'];
        $this->view = $content['view'];
        $this->note = $content['note'];
        $this->files = $content['files'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: $this->view,
            with: [
                'noDisposition' => $this->disposition,
                'memo' => $this->memo,
                'note' => $this->note
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
        $files = [];
        if(count($this->files) > 0){
            $files = array_map(function($data){
                return Attachment::fromStorageDisk('local', $data);
            }, $this->files);
        }

        return $files;
    }
}
