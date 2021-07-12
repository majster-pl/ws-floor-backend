<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Check if asset assigned to customer
        $customer = Customer::find($this->belongs_to);
        if (isset($customer->customer_name)) {
            $belongs_to_name = $customer->customer_name;
        } else {
            $belongs_to_name = "Unallocated";
        }
        return [
            'id' => $this->id,
            'asset_id' => $this->id,
            'reg' => $this->reg,
            'belongs_to' => ($this->belongs_to == null) ? "Unallocated" : $this->belongs_to,
            'belongs_to_name' => $belongs_to_name,
            'model' => $this->model,
            'make' => $this->make,
            'uuid' => $this->uuid,
            'status' => $this->status,
            'created_by_name' => User::find($this->created_by)->name,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
