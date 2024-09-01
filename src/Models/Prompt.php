<?php

namespace Endritvs\LaravelAIToolkit\Models;

class Prompt extends AIModel
{
    protected $attributes = [];

    public function addContent(string $content)
    {
        if (isset($this->attributes['content'])) {
            $this->attributes['content'] .= "\n" . $content;
        } else {
            $this->attributes['content'] = $content;
        }
        return $this;
    }

    public function execute()
    {
        return $this->provider->execute($this->attributes);
    }
}
