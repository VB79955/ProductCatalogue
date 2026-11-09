<?php

namespace Tests\Feature;

use App\Listeners\LogEnquiryAuditListener;
use App\Listeners\RecordEnquiryAnalyticsListener;
use App\Listeners\SendEnquiryNotificationListener;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class EnquiryQueuedListenersTest extends TestCase
{
    use RefreshDatabase;

    public function test_enquiry_submission_queues_side_effect_listeners(): void
    {
        FakeStoreResponses::fake();
        Queue::fake();

        $this->post(route('enquiries.store', 1), [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '+1 555-0100',
            'message' => 'Is this item still available?',
        ]);

        Queue::assertPushed(CallQueuedListener::class, fn (CallQueuedListener $job) => $job->class === SendEnquiryNotificationListener::class);
        Queue::assertPushed(CallQueuedListener::class, fn (CallQueuedListener $job) => $job->class === LogEnquiryAuditListener::class);
        Queue::assertPushed(CallQueuedListener::class, fn (CallQueuedListener $job) => $job->class === RecordEnquiryAnalyticsListener::class);
    }
}
