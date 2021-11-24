<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Asset;
use App\Models\Depot;
use App\Models\Event;
use App\Models\Company;
use App\Models\Customer;
use App\Events\UpdatedEvent;
use Illuminate\Http\Request;
use App\Mail\BookingDailyUpdate;
use App\Mail\BookingStatusUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\EventResource;
use App\Mail\BookingArrivalConfirmation;
use App\Mail\BookingChangesConfirmation;
use Symfony\Component\HttpFoundation\Response;


class EventUuidController extends Controller
{
    public function show($uuid)
    {
        $event = Event::where("uuid", $uuid)->withTrashed()->first();
        if (isset($event->id)) {
            return new EventResource($event);
        } else {
            return response()->json(['error' => 'Event Not Found!'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        // $event = Event::find($id)->update($request);

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
            'customer' => Customer::find($request->customer_id)->customer_name,
            'others' => $event->others,
            'company_name' => Company::where("id", $event->owner_id)->first()->name,
            'branch' => Depot::where("id", $event->owning_branch)->first()->name,
            'odometer_in' => $event->odometer_in,
            'special_instructions' => $event->special_instructions,
            'arrived_date' => date_format(date_create($request->arrived_date), "d/m/Y H:i"),
            'free_text' => $event->free_text,
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
                // send email
                $email = Customer::find($request->customer_id)->email;
                Mail::to($email)->bcc("szymon@waliczek.org")->send($new_email);
            }
        }

        $event->update($request->all());
        broadcast(new UpdatedEvent())->toOthers();
        return new EventResource($event);

        // return $event;
    }
}
