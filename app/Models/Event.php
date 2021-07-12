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
        'booked_date',
        'dooked_date_time',
        'created_by',
        'allowed_time',
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
