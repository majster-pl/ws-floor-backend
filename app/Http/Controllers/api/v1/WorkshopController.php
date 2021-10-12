<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\Event;
use App\Events\UpdatedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Facade\FlareClient\Http\Response;
use App\Http\Resources\WorkshopResource;
use App\Http\Resources\WorkshopCollection;
use Symfony\Component\VarDumper\Cloner\Data;

class WorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $today_date = new DateTime();
        $today_date = $today_date->format('Y-m-d');
        $depot = $request->depot;

        $events = Event::whereDate('booked_date_time', '<=', [$today_date])
            ->where([['status', 'booked'], ['owning_branch', $depot ? $depot : Auth::user()->default_branch]])
            ->orderBy('events.booked_date_time');

        $others = Event::where([['status', '!=', 'booked'], ['owning_branch', $depot ? $depot : Auth::user()->default_branch]])
            ->orderBy('events.order')
            ->union($events)
            ->get();

        return new WorkshopCollection($others);
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
        $items = $request->order;
        // $items = explode(" ", $items);
        $eventIndex = 0;
        foreach ($items as $key => $value) {
            // return $value;
            // return response()->json($value, 200);
            $order = ['order' => $eventIndex];
            $event = Event::find($value);
            $event->update($order);
            $eventIndex += 1;
        }

        // $order = ['order' => 100];
        // $event = Event::find(92);
        // $event->update($order);

        // $array = explode(',', $request->order);
        // foreach ($array as $key => $value) {
        // }
        // return dd($request->order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $event = Event::find($id);

        // $event->update($request->all());

        $event->update(
            [
                'status' => $request->status,
            ]
        );

        // get array of new order for list.
        $items = $request->order;
        $eventIndex = 0;
        foreach ($items as $key => $value) {
            // return $value;
            // return response()->json($value, 200);
            $order = ['order' => $eventIndex];
            $tempEvent = Event::find($value);
            $tempEvent->update($order);
            $eventIndex += 1;
        }

        broadcast(new UpdatedEvent())->toOthers();

        // return $request;

        // $event->update($request);
        return $event;

        // $event->update($request->all());
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
