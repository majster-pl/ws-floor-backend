@component('mail::message')
@if (isset($updated["status"]))
@if (str_contains(Str::lower($updated["status"]), "waiting") )
<center><img src="{{URL('storage/email/stop'. rand(1,2).'.png')}}" height="100" alt="Status Logo"></center><br>
@endif
@else
<center><img src="{{URL('storage/email/thumb_up1.png')}}" height="100" alt="Status Logo"></center><br>
@endif

# Dear {{ $data['customer'] }},

This is an confirmation email about changes to you booking.

Reg: <b>{{ $data['reg'] }} </b><br>

<b class="text-info">Changes:</b><br>
@if (isset($updated["breakdown"]))
Breakdown: <b><strike class="text-danger">{{$data['breakdown'] ? "Yes" : "No"}}</strike> -> <label class="text-success">{{$updated['breakdown'] ? "Yes" : "No"}}</label></b><br>
@endif
@if (isset($updated["status"]))
Status: <b><strike class="text-danger">{{ $data['status'] }}</strike> -> <label class="text-success">{{ $updated['status'] }}</label></b><br>
@endif
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
@if (isset($updated["waiting"]))
Waiting appointment <b><strike class="text-danger">{{$data['waiting'] ? "Yes" : "No"}}</strike> -> <label class="text-success">{{$updated['waiting'] ? "Yes" : "No"}}</label></b><br>
@endif
@if (isset($updated["free_text"]))
Job Notes:
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $updated['free_text'] }}</textarea><br>
@elseif (isset($data["free_text"]) && strlen($data['free_text']) > 0)
Job Notes:
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea><br>
@endif

<br>
<b class="text-info">Booking details:</b><br>
Location: <b>{{ $data['branch'] }}</b><br>
Planned Date: <b>{{ date_format(date_create($data['booked_date_time']), "d/m/Y H:i") }}</b><br>
Description: <b>{{ $data['description'] }}</b><br>
@if (isset($data["others"]))
Others: <b>{{ $data['others'] }}</b><br><br>
@endif

<br><br>
<small>Changes mady by: <b>{{$data['user']}}</b></small><br>

Please <a href="mailto:{{$data['depot_email']}}?subject=Booking changes request for {{$data['reg']}}&body=Hello {{$data['company_name']}},%0D%0A%0D%0AI would like to amend .....  for {{$data['reg']}}.">contact us</a> if you need to make any changes to this booking.<br><br>

Best Regards,
# {{ config('app.name') }} Team
<small>
    <a style="display: inline-block;" class="attributin" href="https://www.vecteezy.com/free-vector/cartoon">Cartoon Vectors by Vecteezy</a>
</small>
@endcomponent