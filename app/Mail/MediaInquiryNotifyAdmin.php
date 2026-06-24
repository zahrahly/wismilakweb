<?php

namespace App\Mail;

use App\Models\MediaInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MediaInquiryNotifyAdmin extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly MediaInquiry $inquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Media Inquiry — ' . $this->inquiry->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-admin-notification',
        );
    }
}
