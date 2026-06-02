<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    // Cache TTL in seconds (5 minutes)
    const CACHE_TTL = 300;

    /**
     * Get a setting value by key with caching.
     */
    public static function get(string $key, $default = null)
    {
        $all = static::getAllCached();
        return $all[$key] ?? $default;
    }

    /**
     * Set a setting value by key (insert or update) and clear cache.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings_all');
    }

    /**
     * Set multiple settings at once.
     */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings_all');
    }

    /**
     * Get all settings as key => value array with caching.
     */
    public static function getAllCached(): array
    {
        return Cache::remember('site_settings_all', static::CACHE_TTL, function () {
            return static::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get settings by group prefix (e.g. 'product_display_').
     */
    public static function getGroup(string $prefix): array
    {
        $all = static::getAllCached();
        $result = [];
        foreach ($all as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $result[substr($key, strlen($prefix))] = $value;
            }
        }
        return $result;
    }

    /**
     * Return bool value of a setting.
     */
    public static function bool(string $key, bool $default = false): bool
    {
        $val = static::get($key);
        if ($val === null) return $default;
        return in_array($val, ['1', 'true', 'yes', true, 1], true);
    }

    /**
     * Clear cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings_all');
    }
}
