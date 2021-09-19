<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

abstract class BaseCollection extends ResourceCollection
{
    private bool $withPagination;

    public function __construct(Paginator|EloquentCollection $resource, $withPagination = true)
    {
        parent::__construct($resource);

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
