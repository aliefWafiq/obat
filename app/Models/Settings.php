<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        return Cache::remember("settings.{$key}", 86400, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value){
        $setting = self::updateOrCreate(
            ['key' => $key], 
            ['value' => $value]
        );
        Cache::forget("settings.{$key}");
        return $setting;
    }
}
