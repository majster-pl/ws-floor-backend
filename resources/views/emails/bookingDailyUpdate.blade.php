@component('mail::message')
# Dear {{ $data['customer'] }},

This is daily update email to keep you up to date with the status of the repair.<br><br>

Reg: <b>{{ $data['reg'] }} </b><br>

Latest Notes:
<textarea type="text" class="form-control" style="width: 100%; height: 7rem" name="free_text" readonly>{{ $data['free_text'] }}</textarea>

Please <a href="mailto:booking@test.org">contact us</a> if you have any queries.

# {{ config('app.name') }} Team,
@endcomponent
