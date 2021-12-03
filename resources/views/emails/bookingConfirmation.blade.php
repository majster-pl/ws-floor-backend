@component('mail::message')
<center><img src="{{URL('storage/email/confirmation1.png')}}" height="100" alt="Status Logo"></center><br>

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

Please <a href="mailto:{{$data['depot_email']}}?subject=Booking changes request for {{$data['reg']}}&body=Hello {{$data['company_name']}},%0D%0A%0D%0AI would like to amend my booking for {{$data['reg']}}, can you ...">contact us</a> if you need to make any changes to this booking.<br><br>

We are looking forward to seeing you!<br><br>

Best Regards,
# {{ config('app.name') }} Team
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent