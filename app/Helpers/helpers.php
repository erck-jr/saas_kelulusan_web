<?php

use App\Models\Setting;
use App\Models\School;
use Illuminate\Support\Facades\Cache;

if (!function_exists('settings')) {
    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key, $default= null)
    {
        // Cache settings for 24 hours to reduce database queries
        // You can clear this cache when updating settings
        if (app()->bound('current_school')) {
            $school_id = app('current_school')->id;
        } else {
            $school_slug = request()->route('school_slug') ?? request()->query('school_slug') ?? null;
            if($school_slug){
                $school_id = School::where('slug', $school_slug)->first()->id;
            } else {
                return $default;
            }
        }
        $settings = Cache::remember('app_settings_'.$school_id, 60 * 24, function () use($school_id) {
            return Setting::where('school_id', $school_id)->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}
