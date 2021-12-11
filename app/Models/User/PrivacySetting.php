<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int user_id
 * @property int profile_display_mode
 * @property int add_friends_mode
 * @property int message_writing_mode
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property-read User user
 *
 * @method static PrivacySetting|Builder query()
 */
class PrivacySetting extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'profile_display_mode',
        'add_friends_mode',
        'message_writing_mode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
