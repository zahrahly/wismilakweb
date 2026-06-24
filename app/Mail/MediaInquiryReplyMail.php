<?php

namespace App\Mail;

use App\Models\MediaInquiry;
use App\Models\MediaInquiryReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MediaInquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly MediaInquiry $inquiry,
        public readonly string $replyMessage
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reply from Wismilak Premium Cigars — Media Relations',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.media-reply',
        );
    }
}
