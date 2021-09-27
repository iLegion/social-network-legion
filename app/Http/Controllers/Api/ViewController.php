<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\View\ViewStoreRequest;
use App\Services\ViewService;
use Illuminate\Http\JsonResponse;

class ViewController extends Controller
{
    public function store(ViewStoreRequest $request, ViewService $viewService): JsonResponse
    {
        $request = $request->validated();

        $model = $viewService->getModel($request['id'], $request['type']);

        $model->addView($this->user);

        return response()->json([], 204);
    }
}
