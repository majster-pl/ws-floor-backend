<?php

namespace App\Models;

// use App\Models\Customer;
use App\Models\User;
use App\Models\Company;
use App\Models\Customer;
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
        'owner_id',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'belongs_to', 'id');
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
