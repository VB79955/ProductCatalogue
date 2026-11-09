<?php

namespace App\Mail;

use App\Models\ProductEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProductEnquiry $enquiry,
        public string $productTitle,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New product enquiry: '.$this->productTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.enquiry-admin',
        );
    }
}
