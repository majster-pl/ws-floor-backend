@component('mail::message')
# Booking Confirmation {{ $data['reg'] }}

This is an email to confirm a booking for <b>{{ $data['reg'] }} </b> on <b>{{ $data['booked_date_time'] }}</b> for {{ $data['description'] }}.

{{-- @component('mail::button', ['url' => ''])
Confirm
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
