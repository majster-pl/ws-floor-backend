@component('mail::message')
<center><img src="{{URL('storage/email/breakdown'.rand(1,2).'.jpg')}}" style="width:35%" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is confirmation email of new <b class="text-danger">breakdown</b> for <b>{{ $data['reg'] }}</b>.<br>

Attending Dealer: <b>{{ $data['company_name'] }} - {{ $data['branch'] }}</b>.<br>
Reg: <b>{{ $data['reg'] }} </b><br>
Date: <b>{{ $data['booked_date_time'] }}</b> <br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br>
@endif

Thank you for choosing us, our mobile technician will be happy to assist you with your breakdown today.<br>

<br>
<small>Booking created by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:booking@test.org">contact us</a> if you need to make any changes to this booking.

We are looking forward to seeing you!<br>
# {{ config('app.name') }} Team,
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent