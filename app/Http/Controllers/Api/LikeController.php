<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Like\LikeRequest;
use App\Http\Requests\Like\LikeStoreRequest;
use App\Services\LikeService;
use Exception;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function store(LikeStoreRequest $request, LikeService $service): JsonResponse
    {
        $id = $request->post('id');
        $type = $request->post('type');

        try {
            $model = $service->getModel($id, $type);

            $model->addLike($this->user);

            return response()->json([], 204);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws InternalServerErrorException
     */
    public function delete(LikeRequest $request, LikeService $service): JsonResponse
    {
        $id = $request->input('id');
        $type = $request->input('type');

        try {
            $model = $service->getModel($id, $type);

            $model->deleteLike($this->user);

            return response()->json([], 204);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
