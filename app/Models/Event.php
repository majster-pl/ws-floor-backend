<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'asset_id',
        'customer_id',
        'waiting',
        'others',
        'status',
        'description',
        'booked_date',
        'dooked_date_time',
        'created_by',
        'allowed_time',
    ];


    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
