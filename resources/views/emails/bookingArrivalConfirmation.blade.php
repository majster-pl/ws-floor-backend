@component('mail::message')
# Dear {{ $data['customer'] }},

This is automated email to let you know that vehicle is now 
with us and is currently queuing in the workshop.<br>

Reg: <b>{{ $data['reg'] }} </b><br>
@if (isset($updated["odometer_in"]))
Current Mileage: <b>{{ $updated['odometer_in'] }} km</b><br>
@endif
@if (isset($updated["special_instructions"]))
Notes from driver: <b>{{ $updated['special_instructions'] }}</b><br>
@endif
Arrival time & date:  <b>{{ date_format(date_create($updated['arrived_date']), "d/m/Y H:i") }}</b><br>

<b style="color: green">Booking details:</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Booking Date: <b>{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif

{{-- @component('mail::button', ['url' => ''])
Confirm
@endcomponent --}}
Please <a href="mailto:booking@test.org">contact us</a> if you have any queries.

We are looking forward to seeing you!<br>
# {{ config('app.name') }} Team,
@endcomponent
