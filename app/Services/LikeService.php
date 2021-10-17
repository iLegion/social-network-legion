<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\User\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LikeService
{
    const MODELS = [
        'post' => Post::class
    ];

    /**
     * @throws Exception
     */
    public function isLikeableModel(string $type): bool
    {
        return array_key_exists($type, self::MODELS);
    }

    public function isExists(Model|Post $model, User $user): bool
    {
        return Like::query()
            ->where('likeable_id', $model->id)
            ->where('likeable_type', $model::class)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getModel(int $id, string $type): Model|Post
    {
        /** @var Model $modelName */
        $modelName = self::MODELS[$type];

        return $modelName::query()->find($id);
    }

    /**
     * @throws Exception
     */
    public function create(Model|Post $model, User $user): Like
    {
        $like = new Like();

        $like->likeable_id = $model->id;
        $like->likeable_type = $model::class;

        $like->user()->associate($user);
        $like->save();

        return $like;
    }

    /**
     * @throws Exception
     */
    public function delete(Model|Post $model, User $user): void
    {
        $model->likes()->where('user_id', $user->id)->delete();
    }
}
