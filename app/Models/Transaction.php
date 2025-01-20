<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        "boarding_school_id",
        "room_id",
        "name",
        "email",
        "phone_number",
        "payment_method",
        "payment_status",
        "start_date",
        "duration",
        "total_amount",
        "transaction_date",
        "snap_token",
    ];

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class, "boarding_house_id");
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, "room_id");
    }
}
