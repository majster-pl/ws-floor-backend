<?php

namespace App\Http\Controllers\api\v1;

use DateTime;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
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
    public function index()
    {
        //
        $today_date = new DateTime();
        $today_date = $today_date->format('Y-m-d');

        // return $today_date;
        $events = Event::where('booked_date', '>=', [$today_date])
            ->where('status', 'booked')
            ->orderBy('events.booked_date');
        // ->get();
        // $events = Event::all();
        $others = Event::where('status', '!=', 'booked')
            ->orderBy('events.status')
            ->union($events)
            ->get();

        // $marged = $events->merge($others);
        // $results = $marged->get();

        // return new WorkshopResource($events);
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

        $event->update($request->all());
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
