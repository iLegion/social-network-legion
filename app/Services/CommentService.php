<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CommentService
{
    const MODELS = [
        'post' => Post::class
    ];

    /**
     * @throws Exception
     */
    public function isCommentableModel(string $type): bool
    {
        return array_key_exists($type, self::MODELS)
            ? true
            : throw new Exception("Model '$type' is not commentable");
    }

    public function getModel(int $id, string $type): Model|null
    {
        /** @var Model $modelName */
        $modelName = self::MODELS[$type];

        return $modelName::query()->findOrFail($id);
    }

    public function getCommentsByModel(int $id, string $type)
    {
        $model = $this->getModel($id, $type);

        return $model->comments();
    }

    public function create(Post $model, User $user, string $text): Comment
    {
        $comment = new Comment();

        $comment->commentable_id = $model->id;
        $comment->commentable_type = $model::class;
        $comment->text = $text;

        $comment->user()->associate($user);
        $comment->save();

        return $comment;
    }

    public function update(Comment $model, User $user, string $text): Comment
    {
        $model->text = $text;

        $model->save();

        return $model;
    }

    /**
     * @throws Exception
     */
    public function delete(Post $model, User $user): void
    {
        $model->comments()->where('user_id', $user->id)->delete();
    }
}
