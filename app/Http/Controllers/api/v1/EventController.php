<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\User;
use App\Models\Asset;
use App\Models\Event;
use App\Events\NewEvent;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Events\UpdatedEvent;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use App\Mail\BookingArrivalConfirmation;
use App\Mail\BookingChangesConfirmation;
use App\Mail\BookingDailyUpdate;
use App\Models\Company;
use App\Models\Depot;
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

        $event = $event->save();

        $data = [
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
        ];

        if ($notification) {
            switch ($request->status) {
                case 'awaiting_labour':
                    break;

                case 'booked':
                    $email = Customer::find($request->customer_id)->email;
                    Mail::to($email)->send(new BookingConfirmation($data));
                    break;

                default:
                    break;
            }
        }



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
        // $event = Event::find($id)->update($request);

        $event = Event::find($id);

        // $data = [
        //     'booked_date_time' => $request->booked_date_time,
        //     'reg' => Asset::find($request->asset_id)->reg,
        //     'description' => $request->description,
        //     'customer' => Customer::find($request->customer_id)->customer_name,
        //     'others' => $request->others,
        //     'key_location' => $request->key_location,
        // ];


        $data = [
            'booked_date_time' => date_format(date_create($request->booked_date_time), "d/m/Y H:i"),
            'reg' => Asset::find($request->asset_id)->reg,
            'description' => $request->description,
            'waiting' => $request->waiting,
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $request->others,
            'company_name' => Company::where("id", $event->owner_id)->first()->name,
            'branch' => Depot::where("id", $event->owning_branch)->first()->name,
            'odometer_in' => $request->odometer_in,
            'special_instructions' => $request->special_instructions,
            'arrived_date' => date_format(date_create($request->arrived_date), "d/m/Y H:i"),
            'free_text' => $request->free_text,
        ];

        // check if status updated, if not user to received different email
        $status_update = ($request->status !== $event->status ? false : true);

        $event->update($request->all());

        if ($request->notification) {
            if ($status_update) {
                $email = Customer::find($request->customer_id)->email;
                Mail::to($email)->send(new BookingDailyUpdate($data));
            } else {
                switch ($request->status) {
                    case 'awaiting_labour':
                        $email = Customer::find($request->customer_id)->email;
                        Mail::to($email)->send(new BookingArrivalConfirmation($data));
                        break;

                    default:
                        $email = Customer::find($event->customer_id)->email;
                        Mail::to($email)->send(new BookingChangesConfirmation($data));
                        break;
                }
            }
        }

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
