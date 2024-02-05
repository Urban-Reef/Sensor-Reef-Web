<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reef extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the points defined on the Reef.
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
}
