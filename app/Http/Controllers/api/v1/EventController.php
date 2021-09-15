<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EventResource;
use App\Http\Resources\EventCollection;
use App\Models\Asset;
use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $events = Event::all();
        // $event = $events->find(1);
        // $reg = Event::find(1)->asset->reg;
        // $event = Event::paginate(4);
        // $event->reg = $event->asset->reg;
        // return response()->json([$event]);
        $from = $request->from;
        if ($from === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide start date [YYYY-MM-DD hh:mm] using "from" argument in request'
                ]
            ]);
        }
        $numberOfDays = $request->days;
        if ($numberOfDays === null) {
            return response()->json([
                'error' => [
                    'message' => 'unsupported request, please provide number of days [int] using "days" argument in request'
                ]
            ]);
        }

        $to = date('Y-m-d h:m', strtotime(date($from) . ' + ' . $request->days . ' days'));
        // $events = Event::withTrashed()->whereBetween('booked_date', [$from, $to])
        //     ->orderBy('events.booked_date_time')
        //     ->get();
        $events = Event::whereBetween('booked_date_time', [$from, $to])
            ->orderBy('events.booked_date_time')
            ->get();

        return new EventCollection($events);
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
        $event->status = $request->status;
        $event->others = $request->others;

        $event->order = 0;
        $event->created_by = auth()->user()->id;
        $event->uuid = Str::uuid()->toString();

        $event = $event->save();

        $data = [
            'booked_date_time' => $request->booked_date_time,
            'reg' => Asset::find($request->asset_id)->reg,
            'description' => $request->description,
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $request->others,
        ];

        $email = Customer::find($request->customer_id)->email;

        Mail::to($email)->send(new BookingConfirmation($data));

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

        switch ($request->status) {
                // case 'awaiting_labour':
                //     $event->update(
                //         [
                //             'status' => $request->status,
                //             'arrived_date' => new DateTime('now'),
                //             'odometer_in' => $request->odometer_in,
                //             'order' => $request->order,
                //             'special_instructions' => $request->special_instructions,
                //         ]
                //     );
                //     break;

            default:
                $event->update($request->all());
                break;
        }


        // $event->update(
        //     [
        //         'customer_id' => $request->customer_id,
        //         'allowed_time' => $request->allowed_time,
        //         'booked_date_time' => $request->booked_date_time,
        //         'description' => $request->description,
        //         'others' => $request->others,
        //         'status' => $request->status,
        //     ]
        // );


        // return $request;

        // $event->update($request);
        return $event;

        // return $request;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
