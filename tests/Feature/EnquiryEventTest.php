<?php

namespace Tests\Feature;

use App\Events\EnquirySubmitted;
use App\Models\ProductEnquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class EnquiryEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_enquiry_submitted_event_is_dispatched(): void
    {
        FakeStoreResponses::fake();
        Event::fake([EnquirySubmitted::class]);

        $this->post(route('enquiries.store', 1), [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '+1 555-0100',
            'message' => 'Is this item still available?',
        ]);

        Event::assertDispatched(EnquirySubmitted::class, function (EnquirySubmitted $event) {
            return $event->enquiry instanceof ProductEnquiry
                && $event->productTitle === 'Alpha Backpack';
        });
    }
}
