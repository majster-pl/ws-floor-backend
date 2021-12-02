<?php

namespace App\Models;

use App\Models\Depot;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'key_location',
        'odometer_in',
        'allowed_time',
        'spent_time',
        'arrived_date',
        'collected_at',
        'free_text',
        'breakdown',
    ];

    // Activity Logger
    public function getActivitylogOptions(): LogOptions
    {
        $user = "System";
        if (isset(Auth::user()->name)) {
            $user = Auth::user()->name;
        }

        return LogOptions::defaults()
            ->logOnly([
                'status',
                'free_text',
                'asset.reg',
                'customer.customer_name',
                'allowed_time',
                'arrived_date',
                'key_location',
                'others',
                'waiting',
                'description',
                'odometer_in',
                'collected_at',
                'odometer_out',
                'booked_date_time',
                'special_instructions',
                'breakdown',
            ])
            ->setDescriptionForEvent(fn (string $eventName) => "Event {$eventName} by " . $user)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
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


    public function depot()
    {
        return $this->belongsTo(Depot::class, 'owning_branch', 'id');
    }


    public function company()
    {
        return $this->belongsTo(Company::class, 'owner_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
