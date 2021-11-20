<?php

namespace App\Models\Dialog;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $dialog_id
 * @property int $user_id
 * @property string $text
 * @property Carbon $read_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Dialog $dialog
 * @property-read User $user
 *
 * @method static DialogMessage|Builder query()
 * @method static DialogMessage|Builder unread()
 */
class DialogMessage extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'read_at'
    ];

    public function dialog(): BelongsTo
    {
        return $this->belongsTo(Dialog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread(Builder $builder): Builder
    {
        return $builder->whereNull('read_at');
    }
}
