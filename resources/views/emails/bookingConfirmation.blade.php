@component('mail::message')
<center><img src="{{URL('storage/email/confirmation1.jpg')}}" style="width:35%" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is confirmation email of your booking with <b class="text-info">{{ $data['company_name'] }}</b>.<br><br>
Reg: <b>{{ $data['reg'] }} </b><br>
Date: <b>{{ $data['booked_date_time'] }}</b> <br>
Waiting appointment: <b>{{$data['waiting'] ? "Yes" : "No"}}</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br>
@endif

<br>
<small>Booking created by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.

We are looking forward to seeing you!<br>
# {{ config('app.name') }} Team,
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent