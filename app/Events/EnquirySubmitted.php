<?php

namespace App\Events;

use App\Models\ProductEnquiry;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EnquirySubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public ProductEnquiry $enquiry,
        public ?string $productTitle = null,
    ) {}
}
