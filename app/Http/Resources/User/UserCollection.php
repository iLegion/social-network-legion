<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseCollection;

class UserCollection extends BaseCollection
{
    public function toArray($request): array
    {
        return parent::toArray($this->collection);
//        return $this->collection->map(function (UserResource $user) use ($request) {
//            return $user->setAdditionalData(collect([
//                'isMyFriendsIDs' => $this->getMyFriendsIDs()
//            ]))->toArray($request);
//        })->toArray();
    }

    private function getMyFriendsIDs(): array
    {
        return $this
            ->authUser
            ->hasFriends($this->collection->pluck('id')->toArray())
            ->toArray();
    }

    private function getDialogsIDs(): array
    {
        return $this
            ->authUser
            ->dialogs()
            ->whereHas('users', function ($builder) {
                $builder->where('user_id', $this->collection->pluck('id')->toArray());
            })
            ->pluck('id')
            ->toArray();
    }
}
