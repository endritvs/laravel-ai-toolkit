<?php

return [

    'default_provider' => env('AI_DEFAULT_PROVIDER', 'claude'),

    'providers' => [

        'gpt' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\GPTProvider::class,
            'model' => env('GPT_MODEL', 'gpt-4o-mini'),
            'max_tokens' => env('GPT_MAX_TOKENS', 4000),
        ],

        'claude' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\ClaudeProvider::class,
            'model' => env('CLAUDE_MODEL', 'anthropic.claude-v2'),
            'max_tokens' => env('CLAUDE_MAX_TOKENS', 6000),
            'region' => env('AWS_REGION', 'us-west-2'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ],
        'gemini' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\GeminiProvider::class,
            'api_key' => env('GEMINI_API_KEY'),
            'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/'),
            'model' => env('GEMINI_MODEL', 'gemini-1.5-flash-latest'),
        ],
    ],

    'defaults' => [
        'temperature' => 0.7,
        'max_tokens' => 4000,
        'top_p' => 1.0,
    ],
];
