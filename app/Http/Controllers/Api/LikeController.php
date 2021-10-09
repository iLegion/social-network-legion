<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Like\LikeStoreRequest;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function store(LikeStoreRequest $request, LikeService $likeService): JsonResponse
    {
        $id = $request->post('id');
        $type = $request->post('type');

        $model = $likeService->getModel($id, $type);

        $model->addLike($this->user);

        return response()->json([], 204);
    }

    public function delete(LikeStoreRequest $request, LikeService $likeService): JsonResponse
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $model = $likeService->getModel($id, $type);

        $model->deleteLike($this->user);

        return response()->json([], 204);
    }
}
