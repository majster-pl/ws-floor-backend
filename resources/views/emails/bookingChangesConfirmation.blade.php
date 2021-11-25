@component('mail::message')
<center><img src="{{URL('storage/email/thumb_up1.jpg')}}" style="width:35%" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is an confirmation email about changes to you booking.

Reg: <b>{{ $data['reg'] }} </b><br>

<b style="color: green">Changes:</b><br>
@if (isset($updated["breakdown"]))
<b>Breakdown</b> <strike style="color: red">{{$data['breakdown'] ? "Yes" : "No"}}</strike> -> <label style="color: green">{{$updated['breakdown'] ? "Yes" : "No"}}</label><br>
@endif
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
@if (isset($updated["waiting"]))
<b>Waiting appointment</b> <strike style="color: red">{{$data['waiting'] ? "Yes" : "No"}}</strike> -> <label style="color: green">{{$updated['waiting'] ? "Yes" : "No"}}</label><br>
@endif
@if (isset($updated["free_text"]))
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea><br>
@elseif (isset($data["free_text"]) && strlen($data['free_text']) > 0)
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea><br>
@endif

<br>
<b style="color: green">Booking details:</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Planned Date: <b>{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif

<br><br>
<small>Changes mady by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.<br>

# {{ config('app.name') }} Team,
@endcomponent