@component('mail::message')
<center><img src="{{URL('storage/email/breakdown'.rand(1,2).'.png')}}" height="100" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is confirmation email of new <b class="text-danger">breakdown</b> for <b>{{ $data['reg'] }}</b>.<br><br>
<b class="text-info">Booking details:</b><br>
Attending Dealer: <b>{{ $data['company_name'] }} - {{ $data['branch'] }}</b>.<br>
Reg: <b>{{ $data['reg'] }} </b><br>
Date: <b>{{ $data['booked_date_time'] }}</b> <br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br>
@endif


<br>
<small>Booking created by: <b>{{$data['user']}}</b></small><br><br>

Please <a href="mailto:{{$data['depot_email']}}?subject=Breakdown booking changes request for {{$data['reg']}}&body=Hello {{$data['company_name']}},%0D%0A%0D%0AI would like to amend .....  for {{$data['reg']}}.">contact us</a> if you need to make any changes to this booking.<br><br>
Thank you for choosing us, our mobile technician will be happy to assist you with your breakdown today.<br><br>

Best Regards,
# {{$data['company_name']. " - ". $data['branch'] }} Team.
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent