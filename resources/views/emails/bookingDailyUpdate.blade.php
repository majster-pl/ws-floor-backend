@component('mail::message')
<center><img src="{{URL('storage/email/notification'.rand(1,4).'.png')}}" style="width:35%" alt="Status Logo"></center><br>

# Dear {{ $data['customer'] }},

This is daily update email to keep you up to date with the status of the repair.<br>

Reg: <b>{{ $data['reg'] }} </b><br>

<label class="text-info"><b>Updates:</b></label><br>
@if (isset($updated["booked_date_time"]))
Booking Date: <b><strike class="text-danger">{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</strike> -> <label class="text-success">{{ date_format(date_create($updated['booked_date_time']), "d/m/Y H:i") }}</label></b><br>
@endif
@if (isset($updated["description"]))
Description: <b><strike class="text-danger">{{ $data['description'] }}</strike> -> <label class="text-success">{{ $updated['description'] }}</label></b><br>
@endif
@if (isset($updated["others"]))
Others: <b><strike class="text-danger">{{ $data['others'] }}</strike> -> <label class="text-success">{{ $updated['others'] }}</label></b><br>
@endif
@if (isset($updated["allowed_time"]))
Allowed Time: <b><strike class="text-danger">{{ $data['allowed_time'] }}h</strike> -> <label class="text-success">{{ $updated['allowed_time'] }}h</label></b><br>
@endif
@if (isset($updated["free_text"]))
<label>Job Notes:</label>
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea>
@elseif (strlen($data["free_text"]) > 0)
<label>Job Notes:
    <textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>
</label>
@endif

<br><br>
<small>Status updated by: <b>{{$data['user']}}</b></small><br>
Please <a href="mailto:{{$data['depot_email']}}?subject=Daily update query for {{$data['reg']}}&body=Hello {{$data['company_name']}},%0D%0A%0D%0AI have a query on the update I've received from you, ..... ">contact us</a> if you have any queries.<br><br>

Best Regards,
# {{ config('app.name') }} Team
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent