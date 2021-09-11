<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

abstract class BaseResource extends JsonResource
{
    #[Pure]
    public function __construct(Model|Collection $resource)
    {
        parent::__construct($resource);
    }
}
