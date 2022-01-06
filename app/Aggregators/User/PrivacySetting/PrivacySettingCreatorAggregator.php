<?php

namespace App\Aggregators\User\PrivacySetting;

use App\Models\User\PrivacySetting;
use App\Models\User\User;

class PrivacySettingCreatorAggregator
{
    private PrivacySetting $builder;

    public function __construct()
    {
        $this->builder = new PrivacySetting();
    }

    public function setUser(User $user): static
    {
        $this->builder->user()->associate($user);

        return $this;
    }

    public function setProfileDisplayMode(int $value): static
    {
        $this->builder->profile_display_mode = $value;

        return $this;
    }

    public function setAddFriendsMode(int $value): static
    {
        $this->builder->add_friends_mode = $value;

        return $this;
    }

    public function setMessageWritingMode(int $value): static
    {
        $this->builder->message_writing_mode = $value;

        return $this;
    }

    public function create(): PrivacySetting
    {
        $this->builder->save();

        return $this->builder;
    }
}
