<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User\User;
use App\Models\View;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ViewService
{
    const MODELS = [
        'post' => Post::class
    ];

    /**
     * @throws Exception
     */
    public function isViewableModel(string $type): bool
    {
        return array_key_exists($type, self::MODELS)
            ? true
            : throw new Exception("Model '$type' is not viewable");
    }

    public function isExists(Model $model, User $user): bool
    {
        return View::query()
            ->where('viewable_id', $model->id)
            ->where('viewable_type', $model::class)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getModel(int $id, string $type): Model|null
    {
        /** @var Model $modelName */
        $modelName = self::MODELS[$type];

        return $modelName::query()->findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public function create(Model $model, User $user): View
    {
        $view = new View();

        $view->viewable_id = $model->id;
        $view->viewable_type = $model::class;

        $view->user()->associate($user);
        $view->save();

        return $view;
    }
}
