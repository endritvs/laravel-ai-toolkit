<?php

namespace Endritvs\LaravelAIToolkit;

use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ai.php' => config_path('ai.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../config/openai.php' => config_path('openai.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ai.php', 'ai'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/openai.php', 'openai'
        );
    }
}
