<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'point_id',
        'type',
        'unit'
    ];

    public function point(): BelongsTo
    {
        return $this->belongsTo(Point::class);
    }

    public function SensorData(): HasMany
    {
        return $this->hasMany(SensorData::class);
    }
}
