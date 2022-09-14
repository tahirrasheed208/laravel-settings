<?php

namespace TahirRasheed\LaravelSettings;

use Illuminate\Support\Facades\Cache;

trait CacheHelper
{
    /**
     * Get value from cache.
     *
     * @param  string  $key
     * @return mixed|void
     */
    public function getFromCache(string $key)
    {
        if (!config('settings.cache.enabled')) {
            return;
        }

        return Cache::get($this->getKey($key));
    }

    /**
     * Set value in cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function saveInCache(string $key, $value)
    {
        if (!config('settings.cache.enabled')) {
            return;
        }

        Cache::put($this->getKey($key), $value);
    }

    /**
     * Delete value from cache.
     *
     * @param  string  $key
     * @return void
     */
    public function forgetCache(string $key)
    {
        if (!config('settings.cache.enabled')) {
            return;
        }

        Cache::forget($this->getKey($key));
    }

    /**
     * Get cache item key.
     *
     * @param  string  $key
     * @return string
     */
    private function getKey(string $key): string
    {
        $prefix = config('settings.cache.key');

        return $prefix . $key;
    }
}
