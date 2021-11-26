@component('mail::message')
<center><img src="{{URL('storage/email/wrench'.rand(1,5).'.png')}}" style="width:35%" alt="Wrench image"></center><br>

# Dear {{ $data['customer'] }},

This is an confirmation email about changes to you booking.

Reg: <b>{{ $data['reg'] }} </b><br>

<b class="text-info">Changes:</b><br>
@if (isset($updated["status"]))
Status: <b><strike class="text-danger">{{ ucfirst(str_replace("_", " ", $data['status'])) }}</strike> -> <label class="text-success">{{ ucfirst(str_replace("_", " ", $updated['status'])) }}</label></b><br>
@endif
@if (isset($updated["free_text"]))
Job Notes:
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea>
@elseif (isset($data['free_text']))
Job Notes:
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>
@endif

<br><br>
<b class="text-info">Booking details:</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Planned Date: <b>{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif

<br><br>
<small>Status updated by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you have any queries.<br>

# {{ config('app.name') }} Team,
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent