@component('mail::message')
# Dear {{ $data['customer'] }},

This is daily update email to keep you up to date with the status of the repair.<br>

Reg: <b>{{ $data['reg'] }} </b><br>

<b style="color: green">Updates:</b><br><br>
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
@elseif (strlen($data["free_text"]) > 0)
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>
@endif

<br><br>
<small>Status updated by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you have any queries.<br>

# {{ config('app.name') }} Team,
@endcomponent