<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseCollection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

class UserCollection extends BaseCollection
{
    /**
     * @param mixed $resource
     * @return mixed
     */
    public function collectResource($resource)
    {
        if ($resource instanceof MissingValue) {
            return $resource;
        }

        if (is_array($resource)) {
            $resource = new Collection($resource);
        }

        $this->collection = $resource->toBase();

        return ($resource instanceof AbstractPaginator || $resource instanceof AbstractCursorPaginator)
            ? $resource->setCollection($this->collection)
            : $this->collection;
    }

    public function toArray($request): array
    {
        $additionalData = collect([
            'isMyFriendsIDs' => $this->getMyFriendsIDs()
        ]);

        return $this->collection->map(function ($user) use ($additionalData) {
            return new UserResource($user, $additionalData);
        })->toArray();
    }

    private function getMyFriendsIDs(): array
    {
        return $this
            ->authUser
            ->hasFriends($this->collection->pluck('id')->toArray())
            ->toArray();
    }
}
