<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id' => $this->id,
            'customer_id' => $this->id,
            'uuid' => $this->uuid,
            'customer_name' => $this->customer_name,
            'email' => $this->email,
            'customer_contact' => $this->customer_contact,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by_name' => User::find($this->created_by)->name,
            'assets_total' => Asset::where('owner_id', '=', $this->id)->count(),
            'status' => $this->status,
        ];
    }
}
