<?php

namespace App\Models;

// use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reg',
        'uuid',
        'make',
        'model',
        'belongs_to',
        'status',
        'created_by',
    ];
}
