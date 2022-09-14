<?php

if (!function_exists('setting')) {

    /**
     * Get / set the specified setting value.
     *
     * @return \TahirRasheed\LaravelSettings\SettingHelper
     */
    function setting()
    {
        return app('setting');
    }
}
