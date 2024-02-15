<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\User;
use App\Models\Asset;
use App\Models\Depot;
use App\Models\Event;
use App\Models\Company;
use App\Events\NewEvent;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Events\UpdatedEvent;
use Illuminate\Http\Request;
use App\Mail\BookingDailyUpdate;
use App\Mail\BookingConfirmation;
use App\Mail\BookingStatusUpdate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use App\Mail\BookingArrivalConfirmation;
use App\Mail\BookingChangesConfirmation;
use App\Mail\BookingBreakdownConfirmation;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    public function index(Request $request)
    {
        $today_date = new DateTime();
        $today_date = $today_date->format('Y-m-d');
        $depot = $request->depot;
        $events = Event::whereDate('booked_date_time', '=', [$today_date])
            ->where([['owning_branch', $depot ? $depot : Auth::user()->default_branch]])
            ->orderBy('events.booked_date_time')->get();
        return $events;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event;
        $event->asset_id = $request->asset_id;
        $event->customer_id = $request->customer_id;
        $event->description = $request->description;
        $event->booked_date_time = $request->booked_date_time;
        $event->allowed_time = $request->allowed_time;

        //if breakdown check vehilce in with status awaiting_labour
        $event->status = $request->breakdown === true ? "awaiting_labour" : $request->status;
        $event->others = $request->others;
        $event->waiting = $request->waiting;
        $event->owner_id = Auth::user()->owner_id;
        $event->owning_branch = $request->depot;
        $event->breakdown = $request->breakdown;

        $event->order = 0;
        $event->created_by = auth()->user()->id;
        $event->uuid = Str::uuid()->toString();

        $notification = $request->notification;


        $data = [
            'user' => Auth::user()->name,
            'booked_date_time' => date_format(date_create($request->booked_date_time), "d/m/Y H:i"),
            'reg' => Asset::find($request->asset_id)->reg,
            'description' => $request->description,
            'waiting' => $request->waiting,
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $request->others,
            'company_name' => Company::where("id", Depot::where("id", $request->depot)->first()->owner_id)->first()->name,
            'branch' => Depot::where("id", $request->depot)->first()->name,
            'odometer_in' => $request->odometer_in,
            'special_instructions' => $request->special_instructions,
            'depot_email' => Depot::find($event->owning_branch)->email,
        ];

        if ($notification) {
            if ($request->breakdown) {
                $new_email = new BookingBreakdownConfirmation($data);
            } else {
                $new_email = new BookingConfirmation($data);
            }
            // send email
            $email = Customer::find($request->customer_id)->email;
            Mail::to($email)->bcc("szymon@waliczek.org")->send($new_email);
        }

        $event = $event->save();
        broadcast(new NewEvent())->toOthers();

        return $event;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        return new EventResource($event);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        function getArrayOfUpdatedValues($request, $event)
        {
            $request_arr = array_intersect_key($request->post(), $event->toArray());
            $diff = array_diff_assoc($request_arr, $event->toArray());
            return $diff;
        }

        $updated = getArrayOfUpdatedValues($request, $event);

        $data = [
            'user' => Auth::user()->name,
            'status' => $event->status,
            'booked_date_time' => $event->booked_date_time,
            'reg' => Asset::find($request->asset_id)->reg,
            'allowed_time' => $event->allowed_time,
            'description' => $event->description,
            'waiting' => $event->waiting,
            'breakdown' => $event->breakdown,
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $event->others,
            'company_name' => Company::where("id", $event->owner_id)->first()->name,
            'branch' => Depot::where("id", $event->owning_branch)->first()->name,
            'odometer_in' => $event->odometer_in,
            'special_instructions' => $event->special_instructions,
            'arrived_date' => date_format(date_create($request->arrived_date), "d/m/Y H:i"),
            'free_text' => $event->free_text,
            'depot_email' => Depot::find($event->owning_branch)->email,
        ];

        // check if status updated, if not user to received different email
        $daily_update = (isset($updated['free_text']) && count($updated) === 1);
        $status_update = ($event->status !== $request->status);

        // if notification enabled in request send relavent email.
        if ($request->notification) {
            if ($daily_update) {
                $new_email = new BookingDailyUpdate($data, $updated);
            } else {
                switch ($request->status) {
                    case 'awaiting_labour':
                        if ($status_update) {
                            if ($event->arrived_date !== null) {
                                $new_email = new BookingStatusUpdate($data, $updated);
                            } else {
                                $new_email = new BookingArrivalConfirmation($data, $updated);
                            }
                        } else {
                            $new_email = new BookingChangesConfirmation($data, $updated);
                        }
                        break;

                    case 'planned':
                    case 'work_in_progress':
                    case 'awaiting_estimates':
                    case 'awaiting_part':
                    case 'awaiting_authorisation':
                    case 'awaiting_qc':
                    case 'at_3rd_party':
                    case 'completed':
                        if ($status_update) {
                            $new_email = new BookingStatusUpdate($data, $updated);
                        } else {
                            $new_email = new BookingChangesConfirmation($data, $updated);
                        }
                        break;

                    default:
                        $new_email = new BookingChangesConfirmation($data, $updated);
                        break;
                }
            }
            // send email
            $email = Customer::find($request->customer_id)->email;
            Mail::to($email)->bcc("szymon@waliczek.org")->send($new_email);
        }

        $event->update($request->all());
        broadcast(new UpdatedEvent())->toOthers();
        return $event;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id)->delete();
        return $event;
    }
}
