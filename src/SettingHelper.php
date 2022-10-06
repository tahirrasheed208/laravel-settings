<?php

namespace TahirRasheed\LaravelSettings;

use Illuminate\Support\Facades\Storage;
use TahirRasheed\LaravelSettings\Exceptions\MediaLibraryException;
use TahirRasheed\LaravelSettings\Models\Setting;
use TahirRasheed\MediaLibrary\MediaUploadForSetting;
use TahirRasheed\MediaLibrary\MediaLibraryServiceProvider;
use TahirRasheed\MediaLibrary\Models\Media;

class SettingHelper
{
    use CacheHelper;

    /**
     * Get setting option value.
     *
     * @param  string  $option_name
     * @param  mixed  $default
     * @return mixed
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
     * Upload file & save in settings.
     *
     * @param  array  $request
     * @param  string  $file_name
     * @param  string|null  $option_name
     * @return void
     *
     * @throws \TahirRasheed\LaravelSettings\Exceptions\MediaLibraryException
     */
    public function upload(array $request, string $file_name, string $option_name = null)
    {
        if (! app()->providerIsLoaded(MediaLibraryServiceProvider::class)) {
            throw MediaLibraryException::install();
        }

        if (! $option_name) {
            $option_name = $file_name;
        }

        $media = (new MediaUploadForSetting)
            ->disk(config('medialibrary.laravel_settings.disk'))
            ->collection(config('medialibrary.laravel_settings.collection'))
            ->handle($request, $file_name, $option_name);

        if (
            ! isset($request[$file_name])
            && isset($request['remove_' . $file_name])
            && $request['remove_' . $file_name] === 'no'
        ) {
            return;
        }

        Setting::updateOrCreate(
            ['option_name' => $option_name],
            ['option_value' => $media],
        );

        $cache_key = "file_{$option_name}";

        $this->forgetCache($option_name);
        $this->forgetCache($cache_key);
    }

    /**
     * Get uploaded file url.
     *
     * @param  string  $option_name
     * @return mixed
     *
     * @throws \TahirRasheed\LaravelSettings\Exceptions\MediaLibraryException
     */
    public function getFile(string $option_name)
    {
        if (! app()->providerIsLoaded(MediaLibraryServiceProvider::class)) {
            throw MediaLibraryException::install();
        }

        $cache_key = "file_{$option_name}";
        $cache = $this->getFromCache($cache_key);

        if ($cache) {
            return $cache;
        }

        $option = Setting::whereOptionName($option_name)->first();

        if (! $option || ! $option->option_value) {
            return;
        }

        $media = Media::find($option->option_value);

        if (! $media) {
            return;
        }

        $url = Storage::disk($media->disk)->url($media->getFilePath());

        $this->saveInCache($cache_key, $url);

        return $url;
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
