<?php

namespace Endritvs\LaravelAIToolkit\Providers;

use OpenAI\Laravel\Facades\OpenAI;

class GPTProvider extends AIProvider
{
    public function execute(array $attributes)
    {
        $result = OpenAI::chat()->create([
            'model' => $attributes['model'] ?? config('ai.providers.gpt.model'),
            'max_tokens' => $attributes['max_tokens'] ?? 4000,
            'messages' => [
                ['role' => 'user', 'content' => $attributes['content']],
            ]
        ]);

        return $result->choices[0]->message->content;
    }
}
