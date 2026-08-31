<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Str;

class SlugGeneratorService
{
    /**
     * Generate a collision-free URL slug for a guest.
     */
    public function generate(string $name): string
    {
        // 1. Clean honorifics or trailing symbols
        $cleaned = preg_replace('/^(bpk\.?|ibu\.?|saudara\/i|dr\.?|h\.?|hj\.?)\s+/i', '', trim($name));
        $base = Str::limit(Str::slug($cleaned), 25, '');

        if (empty($base)) {
            $base = 'tamu';
        }

        // 2. Generate random 4-character suffix and verify uniqueness
        do {
            $entropy = Str::lower(Str::random(4));
            $slug = $base . '-' . $entropy;
        } while (Guest::where('slug', $slug)->exists());

        return $slug;
    }
}
