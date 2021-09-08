<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

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
        'free_text'
    ];

    // logger
    protected static $logAttributes = [
        'event_id',
        'status',
        'description',
        'customer_id',
        'asset_id',
        'others',
        'special_instructions',
        'arrived_date',
        'odometer_in',
        'allowed_time',
        'booked_date_time',
        'collected_at',
        'waiting',
    ];
    protected static $logName = 'event';
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        // return "Event {$eventName} by System";
        return "Event {$eventName} by " . Auth::user()->name;
    }

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
