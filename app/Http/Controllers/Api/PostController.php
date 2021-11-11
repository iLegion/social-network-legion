<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Services\Post\PostService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * @throws InternalServerErrorException
     */
    public function index(): PostCollection
    {
        try {
            $posts = (new PostService())
                ->getPostsForIndexPage()
                ->paginate(30);

            return new PostCollection($posts);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws InternalServerErrorException
     */
    public function store(PostStoreRequest $request): PostResource
    {
        try {
            $post = (new PostService())->create(
                collect($request->validated()),
                $this->user
            );

            return new PostResource($post);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**\
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function show(Post $post): PostResource
    {
        $this->authorize('view', $post);

        try {
            return new PostResource($post);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $this->authorize('update', $post);

        try {
            $post = (new PostService())->update(
                $post,
                 collect($request->validated())
            );

            return new PostResource($post);
        } catch (Exception $e) {
            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }

    /**
     * @throws AuthorizationException
     * @throws InternalServerErrorException
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('destroy', $post);

        DB::beginTransaction();

        try {
            (new PostService())->delete($post);

            DB::commit();

            return response()->json([], 204);
        } catch (Exception $e) {
            DB::rollBack();

            throw new InternalServerErrorException($e->getMessage(), $e);
        }
    }
}
