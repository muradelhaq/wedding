<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'phone',
        'address',
        'is_opened',
        'opened_at',
        'view_count',
    ];

    protected $casts = [
        'is_opened' => 'boolean',
        'opened_at' => 'datetime',
        'view_count' => 'integer',
    ];

    public function rsvp(): HasOne
    {
        return $this->hasOne(Rsvp::class);
    }

    public function guestbooks(): HasMany
    {
        return $this->hasMany(Guestbook::class);
    }

    public function getPersonalUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    public function getCleanPhoneAttribute(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $this->phone);

        if (Str::startsWith($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }

        return $clean;
    }
}
