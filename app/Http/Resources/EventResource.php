<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
        return [
            'event_id' => $this->id,
            'customer_name' => $this->customer->customer_name,
            'customer_id' => $this->customer->id,
            'reg' => $this->asset->reg,
            'asset_id' => $this->asset->id,
            'booked_date' => $this->booked_date,
            'booked_date_time' => $this->booked_date_time,
            'description' => $this->description,
            'others' => $this->others,
            'isUsed' => true,
            'allowed_time' => $this->allowed_time,
            'status' => $this->status,
        ];
    }

    public function with($request)
    {
        return [
            'version' => env('APP_VER'),
            'valid_as_of' => date('D, d M Y H:i:s'),
        ];
    }

}
