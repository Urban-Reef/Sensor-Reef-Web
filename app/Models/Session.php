<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
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
        return $this->hasMany(PointPhotos::class);
    }
    public function biodiversityEntries(): HasMany
    {
        return $this->hasMany(BiodiversityEntry::class);
    }
    public function reefPhotos(): HasMany
    {
        return $this->hasMany(ReefPhoto::class);
    }
}
