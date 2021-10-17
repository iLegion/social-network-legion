<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\View\ViewStoreRequest;
use App\Services\ViewService;
use Exception;
use Illuminate\Http\JsonResponse;

class ViewController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function store(ViewStoreRequest $request, ViewService $viewService): JsonResponse
    {
        $id = $request->post('id');
        $type = $request->post('type');

        try {
            $model = $viewService->getModel($id, $type);

            $model->addView($this->user);

            return response()->json([], 204);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
