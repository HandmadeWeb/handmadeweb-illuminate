<?php

namespace Michaelr0\HookableActionsAndFilters\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HookableActionsAndFiltersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/hookable-actions-filters.php' => config_path('hookable-actions-filters.php'),
            ], 'config');
        }

        if (function_exists('config') && config('hookable-actions-filters.blade.enable_action_directive')) {
            Blade::directive('action', function ($expression) {
                return "<?php Action::run({$expression}); ?>";
            });
        }

        if (function_exists('config') && config('hookable-actions-filters.blade.enable_filter_directive')) {
            Blade::directive('filter', function ($expression) {
                return "<?php echo Filter::run({$expression}); ?>";
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/hookable-actions-filters.php', 'hookable-actions-filters');
    }
}
