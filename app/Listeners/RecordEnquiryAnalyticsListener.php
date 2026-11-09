<?php

namespace App\Listeners;

use App\Events\EnquirySubmitted;
use App\Models\EnquiryAnalyticsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordEnquiryAnalyticsListener implements ShouldQueue
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
        EnquiryAnalyticsEvent::create([
            'product_enquiry_id' => $event->enquiry->id,
            'product_id' => $event->enquiry->product_id,
            'event_type' => 'enquiry_submitted',
            'occurred_at' => now(),
        ]);
    }
}
