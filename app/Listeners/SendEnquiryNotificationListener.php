<?php

namespace App\Listeners;

use App\Events\EnquirySubmitted;
use App\Mail\EnquiryAdminMail;
use App\Mail\EnquiryReceivedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEnquiryNotificationListener implements ShouldQueue
{
    public string $connection;

    public string $queue = 'enquiries';

    public bool $afterCommit = true;

    public function __construct()
    {
        $this->connection = (string) config('enquiry.queue_connection', config('queue.default'));
    }

    public function handle(EnquirySubmitted $event): void
    {
        $enquiry = $event->enquiry;
        $title = $event->productTitle ?? 'Product #'.$enquiry->product_id;

        Mail::to($enquiry->email)->send(new EnquiryReceivedMail($enquiry, $title));

        $admin = config('enquiry.admin_email');
        if ($admin) {
            Mail::to($admin)->send(new EnquiryAdminMail($enquiry, $title));
        }
    }
}
