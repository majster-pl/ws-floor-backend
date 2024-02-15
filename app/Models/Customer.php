<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_name',
        'uuid',
        'email',
        'created_by',
        'customer_contact',
        'status',
        'owner_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'owner_id', 'id');
    }
}
