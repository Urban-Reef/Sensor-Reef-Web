<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoringSession extends Model
{
    protected $table = 'sessions';
    public function reef(): BelongsTo
    {
        return $this->belongsTo(Reef::class);
    }
    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }
    public function pointPhotos(): HasMany
    {
        return $this->hasMany(PointPhoto::class);
    }
    public function biodiversityEntries(): HasMany
    {
        return $this->hasMany(BiodiversityEntry::class);
    }
}
