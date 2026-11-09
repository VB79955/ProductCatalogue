<?php

namespace App\Observers;

use App\Models\ProductEnquiry;
use Illuminate\Support\Str;

class ProductEnquiryObserver
{
    public function creating(ProductEnquiry $enquiry): void
    {
        if (empty($enquiry->reference)) {
            $enquiry->reference = (string) Str::uuid();
        }

        if (empty($enquiry->status)) {
            $enquiry->status = 'submitted';
        }
    }
}
