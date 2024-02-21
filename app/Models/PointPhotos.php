<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointPhotos extends Model
{
    protected $fillable = [
        'url',
        'point_id',
        'session_id'
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
