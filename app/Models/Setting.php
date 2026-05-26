<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Setting extends Model
{
    use BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match($setting->type) {
            'number' => (float) $setting->value,
            'boolean' => (bool) $setting->value,
            default => $setting->value,
        };
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set(string $key, mixed $value): bool
    {
        return static::where('key', $key)->update(['value' => $value]);
    }

    /**
     * Get all settings in a group
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function group(string $group)
    {
        return static::where('group', $group)->get();
    }
}
