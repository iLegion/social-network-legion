<?php

namespace App\Aggregators\User;

use App\Models\User\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserUpdaterAggregator
{
    private User $builder;

    public function __construct(User $user)
    {
        $this->builder = $user;
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

    public function setAvatar(UploadedFile $value): static
    {
        $avatar = $this->builder->avatar;
        $path = Storage::disk('users')->putFile('/' . $this->builder->id . '/images', $value);

        if ($avatar !== 'core/user.svg') {
            Storage::disk('users')->delete($avatar);
        }

        $this->builder->avatar = $path;

        return $this;
    }

    public function update(): User
    {
        $this->builder->save();

        return $this->builder;
    }
}
