<?php

namespace App\Aggregators\Dialog\DialogMessage;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Models\User\User;

class DialogMessageCreatorAggregator
{
    private DialogMessage $builder;

    public function __construct()
    {
        $this->builder = new DialogMessage();
    }

    public function setDialog(Dialog $dialog): static
    {
        $this->builder->dialog()->associate($dialog);

        return $this;
    }

    public function setUser(User $user): static
    {
        $this->builder->user()->associate($user);

        return $this;
    }

    public function setText(string $value): static
    {
        $this->builder->text = $value;

        return $this;
    }

    public function create(): DialogMessage
    {
        $this->builder->save();

        return $this->builder;
    }
}
