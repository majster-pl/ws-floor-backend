<?php

namespace App\Http\Resources;

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
            'customer_contact' => $this->customer_contact,
            'created_at' => $this->created_at,
            'assets_total' => Asset::where('belongs_to', '=', $this->id)->count(),
            'status' => $this->status,
        ];
    }
}
