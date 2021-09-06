<?php

namespace App\Http\Resources;

use DateTime;
use Spatie\Activitylog\Models\Activity;
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
        $activities = Activity::where('subject_id', $this->id)->orderBy("updated_at", "DESC")->get();
        // return parent::toArray($request);
        // $date_now = new DateTime(date('Y-m-d h:i'));
        return [
            'event_id' => $this->id,
            'customer_name' => $this->customer->customer_name,
            'customer_id' => $this->customer->id,
            'reg' => $this->asset->reg,
            'asset_id' => $this->asset->id,
            'booked_date_time' => $this->booked_date_time,
            'description' => $this->description,
            'special_instructions' => $this->special_instructions,
            'others' => $this->others,
            'order' => $this->order,
            'waiting' => $this->waiting,
            'odometer_in' => $this->odometer_in,
            'isUsed' => true,
            'allowed_time' => $this->allowed_time,
            'spent_time' => $this->spent_time,
            'status' => $this->status,
            'arrived_date' => $this->arrived_date,
            // 'age' => $date_now->diff($this->arrived_date),
            'collected_at' => $this->collected_at,
            'activities' => $activities,
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
