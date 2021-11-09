<?php

namespace App\Models\User;

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
 * @property-read Collection $roles
 * @property-read PrivacySetting $privacySettings
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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    public function privacySettings(): HasOne
    {
        return $this->hasOne(PrivacySetting::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
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
}
