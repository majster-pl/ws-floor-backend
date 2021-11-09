<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use App\Models\Event;
use App\Models\Customer;
use App\Events\UpdatedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EventResource;
use App\Mail\BookingChangesConfirmation;

class EventUuidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $event = Event::where("uuid", $uuid)->first();
        return new EventResource($event);
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

        $data = [
            'booked_date_time' => $request->booked_date_time,
            'reg' => Asset::find($request->asset_id)->reg,
            'description' => $request->description,
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $request->others,
            'key_location' => $request->key_location,
        ];

        $event->update($request->all());

        $notification = $request->notification;
        if ($notification) {
            $email = Customer::find($event->customer_id)->email;
            Mail::to($email)->send(new BookingChangesConfirmation($data));
        }
        broadcast(new UpdatedEvent())->toOthers();

        return new EventResource($event);

        // return $event;
    }

}
