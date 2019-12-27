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
        $this->bootForConsole();

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/./../resources/views', 'manthra');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravelmanthra.php', 'laravelmanthra');

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
            __DIR__ . '/../config/laravelmanthra.php' => config_path('laravelmanthra.php'),
        ], 'laravelmanthra.config');

        $this->publishes([
            __DIR__ . '/stubs/' => base_path('resources/manthra/stubs/'),
        ]);

        $this->publishes([
            __DIR__ . '/ApiController.php' => app_path('Http/Controllers/ApiController.php'),
        ], 'laravel-manthra ApiController');

        $this->publishes([
            __DIR__ . '/../assets/toastr.min.css' => public_path('vendor/manthra/css/toastr.min.css'),
            __DIR__ . '/../assets/toastr.min.js' => public_path('vendor/manthra/js/toastr.min.js'),
        ]);

        $this->commands([
            'NicoAudy\LaravelManthra\Commands\GenerateCrudCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateApiCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateWebCommand',

            'NicoAudy\LaravelManthra\Commands\GenerateControllerCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateApiControllerCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateModelCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateMigrationCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateViewCommand',
            'NicoAudy\LaravelManthra\Commands\GenerateLangCommand',
        ]);
    }
}
