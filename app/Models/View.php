<?php

namespace App\Models;

use App\Models\User\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $viewable_id
 * @property string $viewable_type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model|Eloquent $viewable
 * @property-read User $user
 *
 * @method static Builder|View query()
 */
class View extends Model
{
    use HasFactory;

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
