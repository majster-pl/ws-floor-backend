@component('mail::message')
# Dear {{ $data['customer'] }},

This is confirmation email of your booking with <b style="color: #fa9836">{{ $data['company_name'] }}</b>.<br><br>
Reg: <b>{{ $data['reg'] }} </b><br>
Date: <b>{{ $data['booked_date_time'] }}</b> <br>
Waiting appointment: <b>{{$data['waiting'] ? "Yes" : "No"}}</b><br><br>
Location: <b>{{ $data['branch'] }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif

{{-- @component('mail::button', ['url' => ''])
Confirm
@endcomponent --}}
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.

We are looking forward to seeing you!<br>
# {{ config('app.name') }} Team,
@endcomponent
