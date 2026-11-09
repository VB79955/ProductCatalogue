<x-mail::message>
# New enquiry

**Product:** {{ $productTitle }} (ID {{ $enquiry->product_id }})  
**Reference:** {{ $enquiry->reference }}  
**From:** {{ $enquiry->name }}  
**Email:** {{ $enquiry->email }}  
**Phone:** {{ $enquiry->phone }}

**Message:**

{{ $enquiry->message }}

</x-mail::message>
