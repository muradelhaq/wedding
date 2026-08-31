<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::rememberForever('app_wedding_settings', function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );

        Cache::forget('app_wedding_settings');

        return $setting;
    }

    public static function getAllGrouped(): array
    {
        return Cache::rememberForever('app_wedding_settings_grouped', function () {
            $grouped = [];
            foreach (static::all() as $item) {
                $grouped[$item->group][$item->key] = $item->value;
            }
            return $grouped;
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('app_wedding_settings');
        Cache::forget('app_wedding_settings_grouped');
    }
}
