<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class PaginationResource extends JsonResource
{
    #[ArrayShape([
        'total' => "mixed",
        'count' => "mixed",
        'perPage' => "mixed",
        'currentPage' => "mixed",
        'lastPage' => "mixed"
    ])]
    public function toArray($request): array
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'perPage' => $this->perPage(),
            'currentPage' => $this->currentPage(),
            'lastPage' => $this->lastPage()
        ];
    }
}
