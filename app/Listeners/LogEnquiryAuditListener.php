<?php

namespace App\Listeners;

use App\Events\EnquirySubmitted;
use App\Models\EnquiryAuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEnquiryAuditListener implements ShouldQueue
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
        EnquiryAuditLog::create([
            'product_enquiry_id' => $event->enquiry->id,
            'action' => 'enquiry.submitted',
            'context' => [
                'reference' => $event->enquiry->reference,
                'product_id' => $event->enquiry->product_id,
                'email' => $event->enquiry->email,
            ],
            'created_at' => now(),
        ]);
    }
}
