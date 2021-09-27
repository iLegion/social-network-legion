<?php

namespace App\Traits\Models;

use App\Models\User\User;
use App\Models\View;
use App\Services\ViewService;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Viewable
{
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * @throws Exception
     */
    public function addView(User $user): void
    {
        (new ViewService())->create($this, $user);
    }
}
