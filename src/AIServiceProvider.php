<?php

namespace Endritvs\LaravelAIToolkit;

use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/Config/ai.php' => config_path('ai.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/ai.php', 'ai'
        );
    }
}
