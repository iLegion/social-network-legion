<?php

namespace App\Models;

use App\Models\User\User;
use App\Traits\Models\Commentable;
use App\Traits\Models\Likeable;
use App\Traits\Models\Viewable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $author_id
 * @property string $title
 * @property string $text
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $author
 * @property-read View[]|Collection $views
 *
 * @property-read int $views_count
 * @property-read int $likes_count
 * @property-read int $comments_count
 */
class Post extends Model
{
    use HasFactory, Viewable, Likeable, Commentable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'text'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
