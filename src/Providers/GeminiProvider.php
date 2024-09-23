<?php

namespace Endritvs\LaravelAIToolkit\Providers;

use Endritvs\LaravelAIToolkit\Exceptions\AIProviderException;
use Illuminate\Support\Facades\Http;

class GeminiProvider extends AIProvider
{
    public function execute($attributes)
    {
        try {
            $url = config('ai.providers.gemini.base_url') . 'models/' . config('ai.providers.gemini.model') . ':generateContent?key=' . config('ai.providers.gemini.api_key');

            $body = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $attributes['content']]
                        ]
                    ]
                ]
            ];

            $response = Http::post($url, $body);

            if ($response->successful()) {
                $responseBody = $response->json();

                if (isset($responseBody['candidates'][0]['content']['parts'][0]['text'])) {
                    return $responseBody['candidates'][0]['content']['parts'][0]['text'];
                }

                throw AIProviderException::forInvalidResponse('Gemini', $responseBody);
            }

            $errorMessage = $response->json('error.message', 'Invalid response status');
            throw AIProviderException::forRequestFailure('Gemini', $errorMessage);
        } catch (\Exception $e) {
            throw AIProviderException::forRequestFailure('Gemini', $e->getMessage());
        }
    }
}
