<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'owner_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'owner_id', 'id');
    }
}
