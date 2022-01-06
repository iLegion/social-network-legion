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
 * @property int $commentable_id
 * @property string $commentable_type
 * @property string $text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Model|Eloquent $commentable
 * @property-read User $user
 *
 * @method static Builder|Comment query()
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
