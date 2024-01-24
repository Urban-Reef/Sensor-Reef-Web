<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Point extends Model
{
    use HasFactory;

    public function reef(): BelongsTo
    {
        return $this->belongsTo(Reef::class);
    }
    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class);
    }
}
