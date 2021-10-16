<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Models\Comment;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            )->paginate(30);

            return new CommentCollection($comments);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    public function store(CommentStoreRequest $request, CommentService $service): JsonResponse
    {
        $id = $request->post('id');
        $type = $request->post('type');
        $text = $request->post('text');
        $model = $service->getModel($id, $type);

        $model->addComment($this->user, $text);

        return response()->json([], 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
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
