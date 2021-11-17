<?php

namespace App\Http\Controllers\Api\Dialog;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DialogMessage\DialogMessageStoreRequest;
use App\Http\Resources\DialogMessage\DialogMessageCollection;
use App\Http\Resources\DialogMessage\DialogMessageResource;
use App\Models\Dialog\Dialog;
use App\Services\Dialog\DialogMessage\DialogMessageService;
use Exception;

class DialogMessageController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function index(Dialog $dialog): DialogMessageCollection
    {
        try {
            $dialogMessages = (new DialogMessageService())
                ->getByDialog($dialog)
                ->paginate(30);

            return new DialogMessageCollection($dialogMessages);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws InternalServerErrorException
     */
    public function store(DialogMessageStoreRequest $request, Dialog $dialog): DialogMessageResource
    {
        try {
            $dialogMessage = (new DialogMessageService())->create(
                collect($request->validated()),
                $dialog,
                $this->user
            );

            return new DialogMessageResource($dialogMessage);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
