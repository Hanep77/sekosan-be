<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        "boarding_school_id",
        "name",
        "description",
        "price_per_month",
        "is_available",
        "width",
        "length",
    ];
}
