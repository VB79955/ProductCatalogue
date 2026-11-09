<x-mail::message>
# Thank you, {{ $enquiry->name }}

We received your enquiry about **{{ $productTitle }}**.

**Reference:** {{ $enquiry->reference }}

Our team will get back to you at {{ $enquiry->email }} shortly.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
