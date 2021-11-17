<?php

namespace App\Aggregators\Dialog\DialogMessage;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use Illuminate\Database\Eloquent\Builder;

class DialogMessageQueryBuilderAggregator
{
    private Builder $builder;

    public function __construct(array $relations = [])
    {
        $this->builder = DialogMessage::query()->with($relations);
    }

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function byDialog(Dialog $dialog): static
    {
        $this->builder->whereHas('dialog', function (Builder $builder) use ($dialog) {
            $builder->where('id', $dialog->id);
        });

        return $this;
    }
}
