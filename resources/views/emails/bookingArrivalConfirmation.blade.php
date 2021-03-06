@component('mail::message')
<center><img src="{{URL('storage/email/wrench'.rand(1,5).'.png')}}" height="100" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is automated email from <b>{{$data['company_name']. " - ". $data['branch'] }}</b> to let you 
know that vehicle is now with us and is currently queuing into the workshop.<br>

Reg: <b>{{ $data['reg'] }} </b><br>
@if (isset($updated["odometer_in"]))
Current Mileage: <b>{{ $updated['odometer_in'] }} km</b><br>
@endif
@if (isset($updated["special_instructions"]))
Notes from driver: <b>{{ $updated['special_instructions'] }}</b><br>
@endif
@if (isset($updated["arrived_date"]))
Arrival date & time:  <b>{{ date_format(date_create($updated['arrived_date']), "d/m/Y H:i") }}</b><br>
@endif


<b class="text-info">Booking details:</b><br>
Company: <b>{{ $data['company_name'] }}</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Planned Date: <b>{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif
@if (isset($updated["free_text"]))
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea>
@elseif (isset($data["free_text"]) && strlen($data['free_text']) > 0)
<b>Job Notes:</b>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>
@endif

{{-- @component('mail::button', ['url' => ''])
Confirm
@endcomponent --}}
<br><br>
<small>Checked in by: <b>{{$data['user']}}</b></small><br>

Please <a href="mailto:{{$data['depot_email']}}?subject=Status update query for {{$data['reg']}}&body=Hello {{$data['company_name']}},%0D%0A%0D%0AI have a query on the email I've received from you, ..... ">contact us</a> if you have any queries.<br><br>

Best Regards,
# {{$data['company_name']. " - ". $data['branch'] }} Team.
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent
