<?php

namespace App\Enquiries\Commands;

use App\Events\EnquirySubmitted;
use App\Models\ProductEnquiry;

class SubmitEnquiryHandler
{
    public function handle(SubmitEnquiryCommand $command): ProductEnquiry
    {
        $enquiry = ProductEnquiry::create([
            'product_id' => $command->productId,
            'name' => $command->name,
            'email' => $command->email,
            'phone' => $command->phone,
            'message' => $command->message,
        ]);

        EnquirySubmitted::dispatch($enquiry, $command->productTitle);

        return $enquiry;
    }
}
