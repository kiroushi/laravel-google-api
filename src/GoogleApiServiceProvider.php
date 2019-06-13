<?php

namespace Kiroushi\LaravelGoogleApi;

use Kiroushi\LaravelGoogleApi\GoogleApi;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class GoogleApiServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('google-api.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'google-api');

        $this->app->bind(GoogleApi::class, function ($app) {
            return new GoogleApi;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [GoogleApi::class];
    }
}
