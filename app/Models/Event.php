<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'asset_id',
        'customer_id',
        'waiting',
        'others',
        'status',
        'description',
        'special_instructions',
        'booked_date_time',
        'created_by',
        'order',
        'odometer_in',
        'allowed_time',
        'spent_time',
        'arrived_date',
        'collected_at',
    ];

    protected $casts = [
        'allowed_time' => 'float',
    ];


    public function asset()
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }
}
