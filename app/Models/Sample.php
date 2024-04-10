<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sample extends Model
{
    protected $fillable = [
        'monitoring_session_id',
        'point_id'
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
