<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    public function reef(): BelongsTo
    {
        return $this->belongsTo(Reef::class);
    }
    use HasFactory;
}
