@component('mail::message')
# Dear {{ $data['customer'] }},

This is automated email to let you know that vehicle is now 
with us and is currently queuing in a workshop.<br><br>

Reg: <b>{{ $data['reg'] }} </b><br>
@if (isset($data["odometer_in"]))
Mileage: <b>{{ $data['odometer_in'] }} km</b><br><br>
@endif
@if (isset($data["special_instructions"]))
Notes from driver: <b>{{ $data['special_instructions'] }}</b><br><br>
@endif

Location: <b>{{ $data['branch'] }}</b><br>
Time of arrival:  <b>{{ $data['arrived_date'] }}</b><br>
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
