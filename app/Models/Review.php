<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        "boarding_school_id",
        "content",
        "image",
        "rating"
    ];
}
