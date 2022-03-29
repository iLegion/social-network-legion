<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseCollection;
use App\Models\User\User;

class UserCollection extends BaseCollection
{
    public function toArray($request): array
    {
        $this->getFriends();
        return [];
//        return $this->collection->map(function (User $item) {
//           return new UserResource($item);
//        })->toArray();
    }

    private function getFriends()
    {
        info($this->collection);
        info($this->resource);
        info(get_class($this->collection));
        info(get_class($this->resource));
//        $r = $this->authUser->hasFriends($this->collection);

//        info($r);
    }
}
