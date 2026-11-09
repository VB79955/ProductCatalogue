<?php

namespace Tests\Feature;

use App\Models\EnquiryAnalyticsEvent;
use App\Models\EnquiryAuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class EnquirySideEffectsTest extends TestCase
{
    use RefreshDatabase;

    public function test_listeners_write_audit_and_analytics_and_send_mail_when_queue_is_sync(): void
    {
        FakeStoreResponses::fake();
        Mail::fake();

        $this->post(route('enquiries.store', 1), [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '+1 555-0100',
            'message' => 'Is this item still available?',
        ]);

        $this->assertDatabaseCount('enquiry_audit_logs', 1);
        $this->assertDatabaseHas('enquiry_audit_logs', [
            'action' => 'enquiry.submitted',
        ]);

        $this->assertDatabaseCount('enquiry_analytics_events', 1);
        $this->assertSame(1, EnquiryAnalyticsEvent::query()->value('product_id'));
        $this->assertSame('enquiry_submitted', EnquiryAnalyticsEvent::query()->value('event_type'));

        Mail::assertSent(\App\Mail\EnquiryReceivedMail::class);

        $audit = EnquiryAuditLog::query()->first();
        $this->assertNotNull($audit);
        $this->assertSame(1, $audit->context['product_id']);
    }
}
