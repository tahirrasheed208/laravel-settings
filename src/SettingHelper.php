<?php

namespace TahirRasheed\LaravelSettings;

use TahirRasheed\LaravelSettings\Models\Setting;

class SettingHelper
{
    use CacheHelper;

    /**
     * Get setting option value.
     *
     * @param  string  $option_name
     * @param  mixed  $default
     * @return mixed|void
     */
    public function get(string $option_name, $default = null)
    {
        $cache = $this->getFromCache($option_name);

        if ($cache) {
            return $cache;
        }

        $option = Setting::whereOptionName($option_name)->first();
        $value = optional($option)->option_value;

        if ($default && !$value) {
            return $default;
        }

        $this->saveInCache($option_name, $value);

        return $value;
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
        $this->saveInCache($option_name, $option_value);

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
        $this->forgetCache($option_name);
        Setting::whereOptionName($option_name)->delete();
    }
}
