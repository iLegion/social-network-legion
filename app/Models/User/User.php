<?php

namespace App\Models\User;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Models\Post;
use App\Traits\Models\User\Friendable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $avatar
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read PrivacySetting $privacySettings
 * @property-read Collection<int, Role> $roles
 * @property-read Collection<int, DialogMessage> $dialogMessages
 * @property-read Collection<int, Dialog> $dialogsOwner
 * @property-read Collection<int, Dialog> $dialogs
 *
 * @property-read int $posts_count
 *
 * @method static User|Builder query()
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Friendable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'privacySettings'
    ];

    /**
     * @var string[]
     */
    protected $attributes = [
        'avatar' => 'core/user.svg'
    ];

    public function isAdmin(): bool
    {
        return $this->roles()->getAdminQuery()->exists();
    }

    public function isUser(): bool
    {
        return $this->roles()->getUserQuery()->exists();
    }

    public function setUserRole(): void
    {
        $this->roles()->attach($this->roles()->getUserQuery()->select('id')->pluck('id'));
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function dialogMessages(): HasMany
    {
        return $this->hasMany(DialogMessage::class);
    }

    public function dialogsOwner(): HasMany
    {
        return $this->hasMany(Dialog::class);
    }

    public function privacySettings(): HasOne
    {
        return $this->hasOne(PrivacySetting::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function dialogs(): BelongsToMany
    {
        return $this->belongsToMany(Dialog::class);
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'friend_user',
            'user_id',
            'friend_id'
        );
    }
}
