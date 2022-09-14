<?php

namespace TahirRasheed\LaravelSettings;

use Illuminate\Support\Facades\Cache;
use TahirRasheed\LaravelSettings\Models\Setting;

class SettingHelper
{
    /**
     * Get setting option value.
     *
     * @param  string  $option_name
     * @return mixed|void
     */
    public function get(string $option_name)
    {
        $cache = Cache::get('tr_settings_' . $option_name);

        if ($cache) {
            return $cache['data'];
        }

        $option = Setting::whereOptionName($option_name)->first();

        Cache::put('tr_settings_' . $option_name, optional($option)->option_value);

        return optional($option)->option_value;
    }

    /**
     * Set setting option value.
     *
     * @param  string  $option_name
     * @param  mixed  $option_value
     * @return void
     */
    public function put(string $option_name, $option_value)
    {
        Cache::put('tr_settings_' . $option_name, $option_value);

        Setting::updateOrCreate(
            ['option_name' => $option_name],
            ['option_value' => $option_value],
        );
    }

    /**
     * Delete setting option.
     *
     * @param  string  $option_name
     * @return void
     */
    public function delete(string $option_name)
    {
        Cache::forget('tr_settings_' . $option_name);
        Setting::whereOptionName($option_name)->delete();
    }
}
