<?php

namespace Endritvs\LaravelAIToolkit\Exceptions;

use Exception;

class AIProviderException extends Exception
{
    public static function forInvalidResponse($provider, $response)
    {
        return new static("Invalid response from {$provider} provider: " . json_encode($response));
    }

    public static function forRequestFailure($provider, $message)
    {
        return new static("An error occurred while interacting with the {$provider} provider: {$message}");
    }
}
