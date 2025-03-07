<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends Model
{
    protected $fillable = [
        "rule",
        "description"
    ];

    public function boardingHouses(): BelongsToMany
    {
        return $this->belongsToMany(BoardingHouse::class);
    }
}
