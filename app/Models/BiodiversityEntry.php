<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiodiversityEntry extends Model
{
    protected $fillable = [
        'session_id',
        'point_id',
        'species',
        'count',
    ];

    protected function point(): BelongsTo
    {
        return $this->belongsTo(Point::class);
    }

    protected function session(): BelongsTo
    {
        return $this->belongsTo(MonitoringSession::class);
    }
}
