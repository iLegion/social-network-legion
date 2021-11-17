<?php

namespace App\Aggregators\Dialog;

use App\Models\Dialog\Dialog;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class DialogCreatorAggregator
{
    private Dialog $builder;

    public function __construct()
    {
        $this->builder = new Dialog();
    }

    public function getBuilder(): Dialog
    {
        return $this->builder;
    }

    public function setOwner(User $user): static
    {
        $this->builder->owner()->associate($user);

        return $this;
    }

    public function setTitle(string $value): static
    {
        $this->builder->title = $value;

        return $this;
    }

    public function setUsers(EloquentCollection | Collection $users): static
    {
        $this->builder->users()->sync($users);

        return $this;
    }

    public function create(): static
    {
        $this->builder->save();

        return $this;
    }
}
