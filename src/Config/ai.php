<?php

return [

    'default_provider' => env('AI_DEFAULT_PROVIDER', 'claude'),

    'providers' => [

        'gpt' => [
            'class' => \Endritvs\LaravelAIToolkit\Providers\GPTProvider::class,
            'model' => env('GPT_MODEL', 'gpt-3.5-turbo'),
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
    ],

    'defaults' => [
        'temperature' => 0.7,
        'max_tokens' => 4000,
        'top_p' => 1.0,
    ],
];
