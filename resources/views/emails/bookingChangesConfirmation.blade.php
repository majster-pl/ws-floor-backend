@component('mail::message')
# Dear {{ $data['customer'] }},

This is an email to confirm changes to you booking.<br><br>
Please find below updated details:<br>
Reg: <b>{{ $data['reg'] }} </b><br>
Date: <b>{{ $data['booked_date_time'] }}</b> <br>
Booked for: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b>
@endif
<br><br>
{{-- @component('mail::button', ['url' => ''])
Confirm
@endcomponent --}}
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.

We are looking forward to seeing you,<br>
# {{ config('app.name') }} Team,
@endcomponent