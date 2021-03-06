<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class WorkshopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        // return parent::toArray($request);
        $date_now = new DateTime('today');
        // reset arrive date to 00:00h to count days after midnight
        $date_arrived = date_create(date_format(date_create($this->arrived_date), "Y-m-d"));

        return [
            'id' => 'event-' . $this->id,
            'event_id' => $this->id,
            'customer_name' => $this->customer->customer_name,
            'customer_id' => $this->customer->id,
            'reg' => $this->asset->reg,
            'asset_id' => $this->asset->id,
            'booked_date_time' => $this->booked_date_time,
            'description' => $this->description,
            'special_instructions' => $this->special_instructions,
            'others' => $this->others,
            'waiting' => $this->waiting,
            'odometer_in' => $this->odometer_in,
            'breakdown' => $this->breakdown,
            'order' => $this->order,
            'isUsed' => true,
            'key_location' => $this->key_location,
            'allowed_time' => $this->allowed_time,
            'status' => $this->status,
            'arrived_date' => $this->arrived_date,
            'updated_at' => $this->updated_at,
            'age' => $date_now->diff($date_arrived)->format('%a'),
        ];
    }
}
