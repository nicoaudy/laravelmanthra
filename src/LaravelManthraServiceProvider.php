<?php

namespace NicoAudy\LaravelManthra;

use Illuminate\Support\ServiceProvider;

class LaravelManthraServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelmanthra.php', 'laravelmanthra');

        $this->app->singleton('laravelmanthra', function ($app) {
            return new LaravelManthra;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelmanthra'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        $this->publishes([
            __DIR__.'/../config/laravelmanthra.php' => config_path('laravelmanthra.php'),
        ], 'laravelmanthra.config');

        $this->publishes([
            __DIR__ . '/stubs/' => base_path('resources/manthra/stubs/'),
        ]);

        $this->commands([
            'NicoAudy\LaravelManthra\Commands\GenerateCrudCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateControllerCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateModelCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateMigrationCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateViewCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateLangCommand',
        ]);
    }
}
