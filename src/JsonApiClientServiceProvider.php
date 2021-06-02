<?php

namespace Nos\JsonApiClient;

use Illuminate\Support\ServiceProvider;

class JsonApiClientServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nos');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'nos');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/jsonapiclient.php', 'jsonapiclient');

        // Register the service the package provides.
        $this->app->singleton('jsonapiclient', function ($app) {
            return new JsonApiClient;
        });

        $this->app->bind(Client::class, function ($app) {
            return new Client();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['jsonapiclient'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/jsonapiclient.php' => config_path('jsonapiclient.php'),
        ], 'jsonapiclient.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/nos'),
        ], 'jsonapiclient.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/nos'),
        ], 'jsonapiclient.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/nos'),
        ], 'jsonapiclient.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
