<?php

namespace App\Aggregators\User;

use App\Models\User\User;

class UserCreatorAggregator
{
    private User $builder;

    public function __construct()
    {
        $this->builder = new User();
    }

    public function setEmail(string $value): static
    {
        $this->builder->email = $value;

        return $this;
    }

    public function setName(string $value): static
    {
        $this->builder->name = $value;

        return $this;
    }

    public function setPassword(string $value): static
    {
        $this->builder->password = bcrypt($value);

        return $this;
    }

    public function create(): User
    {
        $this->builder->save();

        return $this->builder;
    }
}
