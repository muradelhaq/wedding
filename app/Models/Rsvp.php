<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'attendance',
        'total_guest',
        'notes',
    ];

    protected $casts = [
        'total_guest' => 'integer',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
