<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class SendPreMemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $memo;
    public $files;
    public $link;
    public $view;
    public $note;

    /**
     * Create a new message instance.
     */
    public function __construct($content)
    {
        $this->title = $content['title'];
        $this->memo  = $content['number_transaction'];
        $this->files = $content['files'];
        $this->link = $content['link'];
        $this->view = $content['view'];
        $this->note = $content['note'];
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
                'noMemo' => $this->memo,
                'note' => $this->note,
                'link' => $this->link
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
