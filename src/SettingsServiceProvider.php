<?php

namespace TahirRasheed\LaravelSettings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (! app()->configurationIsCached()) {
            $this->mergeConfigFrom(
                __DIR__.'/../config/settings.php', 'settings'
            );
        }

        $this->app->singleton('setting', function () {
            return new SettingHelper();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/settings.php' => config_path('settings.php'),
            ], 'settings-config');

            $this->publishesMigrations([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'settings-migration');
        }
    }
}