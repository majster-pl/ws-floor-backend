@component('mail::message')
# Dear {{ $data['customer'] }},

This is an confirmation email about changes to you booking.

Reg: <b>{{ $data['reg'] }} </b><br>

<b style="color: green">Changes:</b><br>
@if (isset($updated["status"]))
<b>Status</b>: <strike style="color: red">{{ $data['status'] }}</strike> -> <label style="color: green">{{ $updated['status'] }}</label><br>
@endif
@if (isset($updated["free_text"]))
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea>
@elseif (isset($data['free_text']))
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>
@endif

<br><br>
<small>Status updated by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you have any queries.<br>

# {{ config('app.name') }} Team,
@endcomponent