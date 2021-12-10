<?php

namespace App\Http\Resources;

use App\Models\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    protected User|Authenticatable|null $user;

    public function __construct(Model $resource)
    {
        parent::__construct($resource);

        $this->user = auth('sanctum')->user();
    }
}
