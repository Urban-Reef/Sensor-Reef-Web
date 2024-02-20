<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReefPhoto extends Model
{
    protected $fillable = [
        'session_id',
        'url',
        'angle',
    ];

    protected function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }
}
