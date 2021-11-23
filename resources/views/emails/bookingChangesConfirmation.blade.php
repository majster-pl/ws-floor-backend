@component('mail::message')
# Dear {{ $data['customer'] }},

This is an confirmation email about changes to you booking.

Reg: <b>{{ $data['reg'] }} </b><br>

<b style="color: green">Changes:</b><br>
@if (isset($updated["status"]))
<b>Status</b>: <strike style="color: red">{{ $data['status'] }}</strike> -> <label style="color: green">{{ $updated['status'] }}</label><br>
@endif
@if (isset($updated["booked_date_time"]))
<b>Booking Date</b>: <strike style="color: red">{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</strike> -> <label style="color: green">{{ date_format(date_create($updated['booked_date_time']), "d/m/Y H:i") }}</label><br>
@endif
@if (isset($updated["description"]))
<b>Description</b>: <strike style="color: red">{{ $data['description'] }}</strike> -> <label style="color: green">{{ $updated['description'] }}</label><br>
@endif
@if (isset($updated["others"]))
<b>Others</b>: <strike style="color: red">{{ $data['others'] }}</strike> -> <label style="color: green">{{ $updated['others'] }}</label><br>
@endif
@if (isset($updated["allowed_time"]))
<b>Allowed Time</b>: <strike style="color: red">{{ $data['allowed_time'] }}h</strike> -> <label style="color: green">{{ $updated['allowed_time'] }}h</label><br>
@endif
@if (isset($updated["free_text"]))
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea>
@endif

<br>
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.

# {{ config('app.name') }} Team,
@endcomponent