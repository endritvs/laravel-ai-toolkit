<?php

namespace Endritvs\LaravelAIToolkit\Models;

use Endritvs\LaravelAIToolkit\QueryBuilder\AIQueryBuilder;

abstract class AIModel
{
    protected $attributes = [];
    protected $provider;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
        $this->provider = app(config('ai.providers.' . config('ai.default_provider') . '.class'));
    }

    public function setProvider(string $provider)
    {
        $this->provider = app(config("ai.providers.{$provider}.class"));
        return $this;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public static function query(): AIQueryBuilder
    {
        $instance = new static;
        return new AIQueryBuilder($instance);
    }

    public function newQuery(): AIQueryBuilder
    {
        return static::query();
    }

    public function execute()
    {
        return $this->provider->execute($this->attributes);
    }

    public function setContent(string $content)
    {
        $this->attributes['content'] = $content;
        return $this;
    }

    public function addContent(string $content)
    {
        if (isset($this->attributes['content'])) {
            $this->attributes['content'] .= "\n" . $content;
        } else {
            $this->attributes['content'] = $content;
        }
        return $this;
    }

    public function setModel(string $model)
    {
        $this->attributes['model'] = $model;
        return $this;
    }

    public function setMaxTokens(int $maxTokens)
    {
        $this->attributes['max_tokens'] = $maxTokens;
        return $this;
    }
}
