<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property-read Collection users
 */
class Role extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeGetAdminQuery(): Builder
    {
        return $this->query()->where('id', 1);
    }

    public function scopeGetUserQuery(): Builder
    {
        return $this->query()->where('id', 2);
    }
}
