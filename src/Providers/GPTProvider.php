<?php

namespace Endritvs\LaravelAIToolkit\Providers;

use OpenAI\Laravel\Facades\OpenAI;
use Endritvs\LaravelAIToolkit\Exceptions\AIProviderException;

class GPTProvider extends AIProvider
{
    public function execute(array $attributes)
    {
        try {
            $result = OpenAI::chat()->create([
                'model' => $attributes['model'] ?? config('ai.providers.gpt.model'),
                'max_tokens' => $attributes['max_tokens'] ?? 4000,
                'messages' => [
                    ['role' => 'user', 'content' => $attributes['content']],
                ]
            ]);

            if (isset($result->choices[0]->message->content)) {
                return $result->choices[0]->message->content;
            }

            throw AIProviderException::forInvalidResponse('GPT', $result);
        } catch (\Exception $e) {
            throw AIProviderException::forRequestFailure('GPT', $e->getMessage());
        }
    }
}
