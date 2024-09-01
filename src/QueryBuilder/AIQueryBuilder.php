<?php

namespace Endritvs\LaravelAIToolkit\QueryBuilder;

use Endritvs\LaravelAIToolkit\Models\AIModel;

class AIQueryBuilder
{
    protected $model;
    protected $conditions = [];

    public function __construct(AIModel $model)
    {
        $this->model = $model;
    }

    public function where(string $attribute, $value)
    {
        $this->conditions[$attribute] = $value;
        return $this;
    }

    public function setModel(string $model)
    {
        return $this->model->setModel($model);
    }

    public function addContent(string $content)
    {
        return $this->model->addContent($content);
    }

    public function setMaxTokens(int $maxTokens)
    {
        return $this->model->setMaxTokens($maxTokens);
    }

    public function execute()
    {
        foreach ($this->conditions as $attribute => $value) {
            $this->model->{$attribute} = $value;
        }

        return $this->model->execute();
    }
}
