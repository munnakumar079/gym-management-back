<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymDetail extends Model
{
    protected $fillable = [
        'user_id',
        'gym_name',
        'city',
        'address',
    ];
}
