<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Requests\Comment\CommentUpdateRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function index(CommentRequest $request, CommentService $service): CommentCollection
    {
        try {
            $comments = $service->getCommentsByModel(
                $request->get('id'),
                $request->get('type')
            )
                ->latest()
                ->paginate(30);

            return new CommentCollection($comments);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    public function store(CommentStoreRequest $request, CommentService $service): CommentResource
    {
        $id = $request->post('id');
        $type = $request->post('type');
        $text = $request->post('text');
        $model = $service->getModel($id, $type);

        return new CommentResource(
            $model->addComment($this->user, $text)
        );
    }

    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    public function update(CommentUpdateRequest $request, Comment $comment): CommentResource
    {
        $comment = (new CommentService())
            ->update($comment, $request->post('text'));

        return new CommentResource($comment);
    }

    /**
     * @throws InternalServerErrorException
     */
    public function destroy(Comment $comment): JsonResponse
    {
        try {
            $comment->delete();

            return response()->json([], 204);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
