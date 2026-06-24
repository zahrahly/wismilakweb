<?php

namespace App\Mail;

use App\Models\MediaInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MediaInquiryAutoReply extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly MediaInquiry $inquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Media Inquiry Has Been Received — Wismilak Premium Cigars',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry-auto-reply',
        );
    }
}
