<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get setting value by key (with caching).
     */
    public static function get($key, $default = null)
    {
        $cacheKey = "setting." . strtolower($key);
        return Cache::remember($cacheKey, 86400, function () use ($key, $default) {
            $setting = self::whereRaw('LOWER(`key`) = ?', [strtolower($key)])->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value and clear cache.
     */
    public static function set($key, $value)
    {
        $setting = self::whereRaw('LOWER(`key`) = ?', [strtolower($key)])->first();
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            $setting = self::create([
                'key' => $key,
                'value' => $value
            ]);
        }

        Cache::forget("setting." . strtolower($key));
        Cache::forget("setting." . $key);

        return $setting;
    }
}
