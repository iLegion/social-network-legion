<?php

namespace App\Aggregators\Dialog\DialogMessage;

use App\Models\Dialog\DialogMessage;

class DialogMessageUpdaterAggregator
{
    private DialogMessage $builder;

    public function __construct(DialogMessage $dialogMessage)
    {
        $this->builder = $dialogMessage;
    }

    public function setReadAt(string $value): static
    {
        $this->builder->read_at = $value;

        return $this;
    }

    public function update(): DialogMessage
    {
        $this->builder->save();

        return $this->builder;
    }
}
