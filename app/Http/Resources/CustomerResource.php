<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
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
            'created_by_name' => $this->user->name,
            'assets_total' => Asset::where([['belongs_to', '=', $this->id], ["owner_id", Auth::user()->owner_id]])->count(),
            'status' => $this->status,
        ];
    }
}
