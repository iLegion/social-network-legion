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
        $id = $request->post('id');
        $type = $request->post('type');
        $model = $viewService->getModel($id, $type);

        $model->addView($this->user);

        return response()->json([], 204);
    }
}
