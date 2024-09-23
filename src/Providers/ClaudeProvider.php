<?php

namespace Endritvs\LaravelAIToolkit\Providers;

use Aws\BedrockRuntime\BedrockRuntimeClient;
use Aws\BedrockRuntime\Exception\BedrockRuntimeException;
use Endritvs\LaravelAIToolkit\Exceptions\AIProviderException;

class ClaudeProvider extends AIProvider
{
    protected $client;
    protected $model;

    public function __construct()
    {
        $this->client = new BedrockRuntimeClient([
            'region' => config('ai.providers.claude.region', 'us-west-2'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('ai.providers.claude.credentials.key'),
                'secret' => config('ai.providers.claude.credentials.secret'),
            ],
        ]);

        $this->model = config('ai.providers.claude.model', 'anthropic.claude-v2');
    }

    public function execute($attributes)
    {
        try {
            $modelId = $attributes['model'] ?? $this->model;
            $content = "\n\nHuman: " . $attributes['content'] . "\n\nAssistant:";

            $body = [
                'prompt' => $content,
                'max_tokens_to_sample' => $attributes['max_tokens'],
                'temperature' => config('ai.defaults.temperature', 0.7),
                'top_p' => config('ai.defaults.top_p', 1.0),
            ];

            $response = $this->client->invokeModel([
                'body' => json_encode($body),
                'modelId' => $modelId,
                'accept' => 'application/json',
                'contentType' => 'application/json',
            ]);

            $responseBody = json_decode($response->get('body')->getContents(), true);

            if (isset($responseBody['completion'])) {
                return $responseBody['completion'];
            }

            throw AIProviderException::forInvalidResponse('Claude', $responseBody);
        } catch (BedrockRuntimeException $e) {
            throw AIProviderException::forRequestFailure('Claude', $e->getAwsErrorMessage() ?? $e->getMessage());
        } catch (\Exception $e) {
            throw AIProviderException::forRequestFailure('Claude', $e->getMessage());
        }
    }
}
