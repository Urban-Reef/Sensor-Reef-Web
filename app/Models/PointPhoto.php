<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointPhoto extends Model
{
    protected $fillable = [
        'point_id',
        'monitoring_session_id'
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
