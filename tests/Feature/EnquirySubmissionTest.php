<?php

namespace Tests\Feature;

use App\Models\ProductEnquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\FakeStoreResponses;
use Tests\TestCase;

class EnquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_enquiry_requires_valid_fields(): void
    {
        FakeStoreResponses::fake();

        $response = $this->from(route('products.show', 1))
            ->post(route('enquiries.store', 1), []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message']);
    }

    public function test_enquiry_is_stored_and_redirects_to_thank_you(): void
    {
        FakeStoreResponses::fake();

        $response = $this->post(route('enquiries.store', 1), [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '+1 555-0100',
            'message' => 'Is this item still available?',
        ]);

        $enquiry = ProductEnquiry::query()->first();
        $this->assertNotNull($enquiry);
        $this->assertSame('Jane Customer', $enquiry->name);
        $this->assertNotEmpty($enquiry->reference);

        $response->assertRedirect(route('enquiries.thank-you', ['reference' => $enquiry->reference]));
    }

    public function test_thank_you_page_displays_reference(): void
    {
        FakeStoreResponses::fake();

        $this->post(route('enquiries.store', 1), [
            'name' => 'Jane Customer',
            'email' => 'jane@example.com',
            'phone' => '+1 555-0100',
            'message' => 'Is this item still available?',
        ]);

        $enquiry = ProductEnquiry::query()->firstOrFail();

        $this->get(route('enquiries.thank-you', ['reference' => $enquiry->reference]))
            ->assertOk()
            ->assertSee($enquiry->reference)
            ->assertSee('Thank you for your enquiry');
    }
}
