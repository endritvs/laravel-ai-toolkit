<?php

namespace Endritvs\LaravelAIToolkit\Models;

use Exception;

class Prompt extends AIModel
{
    protected $attributes = [];
    protected $fallbackProvider = null; 

    public function addContent(string $content)
    {
        if (isset($this->attributes['content'])) {
            $this->attributes['content'] .= "\n" . $content;
        } else {
            $this->attributes['content'] = $content;
        }
        return $this;
    }

    public function fallback(string $provider)
    {
        $this->fallbackProvider = $provider;
        return $this;
    }

    public function execute()
    {
        try {
            return $this->provider->execute($this->attributes);
        } catch (\Exception $e) {
            if ($this->fallbackProvider) {
                $fallbackModelConfig = config("ai.providers.{$this->fallbackProvider}");

                $this->setProvider($this->fallbackProvider);
                $this->setModel($fallbackModelConfig['model']); 
                $this->setMaxTokens($fallbackModelConfig['max_tokens']); 

                try {
                    return $this->provider->execute($this->attributes);
                } catch (\Exception $fallbackException) {
                    throw new Exception('Both primary and fallback providers failed.');
                }
            }

            throw new Exception('Primary provider failed, and no fallback provider is configured.');
        }
    }
}
