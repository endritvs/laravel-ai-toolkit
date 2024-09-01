<?php

namespace Endritvs\LaravelAIToolkit\Providers;

abstract class AIProvider
{
    abstract public function execute(array $attributes);
}
