<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

abstract class BaseCollection extends ResourceCollection
{
    protected User | Authenticatable | null $authUser;
    protected bool $withPagination;

    public function __construct(Paginator | EloquentCollection $resource, $withPagination = true)
    {
        parent::__construct($resource);

        $this->authUser = auth('sanctum')->user();
        $this->withPagination = $withPagination;
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);

        unset($jsonResponse['links'],$jsonResponse['meta']);

        $response->setContent(json_encode($jsonResponse));
    }

    public function toArray($request): Collection|Request|array
    {
        if ($this->withPagination) {
            return [
                'data' => $request,
                'pagination' => new PaginationResource($this)
            ];
        } else {
            return $request->toArray();
        }
    }
}
