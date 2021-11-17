<?php

namespace App\Models\Dialog;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $owner_id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User $owner
 * @property-read Collection<int, User> $users
 * @property-read Collection<int, DialogMessage> $messages
 *
 * @method static Dialog|Builder query()
 */
class Dialog extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(DialogMessage::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
