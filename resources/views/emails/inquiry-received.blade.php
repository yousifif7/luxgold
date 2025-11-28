@component('mail::message')
# Inquiry Sent Successfully

Thank you for your inquiry to {{ $provider->name }}.

We've received your message and the provider will contact you shortly.

**Your Inquiry Details:**  
Provider: {{ $provider->name }}  
Sent: {{ $inquiry->created_at->format('M j, Y g:i A') }}

**Your Message:**  
{{ $inquiry->message }}

The provider typically responds within 2-4 hours during business hours.

@component('mail::button', ['url' => route('website.find-cleaner')])
Find More Cleaners
@endcomponent

Thanks,  
{{ config('app.name') }} Team
@endcomponent