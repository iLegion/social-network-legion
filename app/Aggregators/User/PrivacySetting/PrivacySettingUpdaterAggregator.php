<?php

namespace App\Aggregators\User\PrivacySetting;

use App\Models\User\PrivacySetting;

class PrivacySettingUpdaterAggregator
{
    private PrivacySetting $builder;

    public function __construct(PrivacySetting $privacySetting)
    {
        $this->builder = $privacySetting;
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

    public function update(): PrivacySetting
    {
        $this->builder->save();

        return $this->builder;
    }
}
