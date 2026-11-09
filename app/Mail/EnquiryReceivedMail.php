<?php

namespace App\Mail;

use App\Models\ProductEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProductEnquiry $enquiry,
        public string $productTitle,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your product enquiry',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.enquiry-received',
        );
    }
}
