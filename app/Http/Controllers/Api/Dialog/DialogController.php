<?php

namespace App\Http\Controllers\Api\Dialog;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dialog\DialogStoreRequest;
use App\Http\Resources\Dialog\DialogCollection;
use App\Http\Resources\Dialog\DialogResource;
use App\Models\Dialog\Dialog;
use App\Models\User\User;
use App\Services\Dialog\DialogService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DialogController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function index(): DialogCollection
    {
        try {
            $dialogs = (new DialogService())
                ->getMyDialogs($this->user)
                ->latest()
                ->paginate(30);

            return new DialogCollection($dialogs);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function store(DialogStoreRequest $request): DialogResource
    {
        $user = User::query()->find($request->post('userID'));

        $this->authorize('storeDialog', $user);

        DB::beginTransaction();

        try {
            $dialog = (new DialogService())
                ->create(
                    $request->post('title'),
                    collect([$user->id])->push($this->user->id),
                    $this->user
                );

            DB::commit();

            return new DialogResource($dialog);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function delete(Dialog $dialog): JsonResponse
    {
        $this->authorize('delete', $dialog);

        DB::beginTransaction();

        try {
            (new DialogService())->delete($dialog);
            DB::commit();

            return response()->json([], 204);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
