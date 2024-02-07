<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reef extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'longitude',
        'latitude',
        'placed_on'
        ];

    protected $casts = [
        'placed_on' => 'date:Y-m-d'
    ];

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
