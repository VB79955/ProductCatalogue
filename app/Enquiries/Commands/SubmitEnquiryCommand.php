<?php

namespace App\Enquiries\Commands;

readonly class SubmitEnquiryCommand
{
    public function __construct(
        public int $productId,
        public string $name,
        public string $email,
        public string $phone,
        public string $message,
        public ?string $productTitle = null,
    ) {}
}
