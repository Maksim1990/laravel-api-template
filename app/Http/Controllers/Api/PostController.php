<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\AbstractCollection;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @OA\Get(
     *      path="/posts",
     *      operationId="getPosts",
     *      tags={"Post"},
     *      summary="Get all posts",
     *      description="Returns all posts details",
     * @OA\Parameter(
     *          name="page",
     *          description="Current page",
     *          required=false,
     *          in="query",
     *          example=1,
     * @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="perPage",
     *          description="Number of items to be retrieved per page",
     *          required=false,
     *          in="query",
     *          example=10,
     * @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="relationships",
     *          description="Relationships that should be inclused in response",
     *          required=false,
     *          in="query",
     *          example="user",
     * @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Parameter(
     *          name="relationPerPage",
     *          description="Number of relationships to be retrieved in response structure",
     *          required=false,
     *          in="query",
     *          example=3,
     * @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successfully received available posts",
     * @OA\JsonContent(ref="#/components/schemas/Post"),
     *       ),
     * @OA\Response(response=400,                          description="Bad request"),
     * @OA\Response(response=401,                          description="Authorization token must be provided"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function index(Request $request)
    {
        return new PostCollection(
            Post::paginate((int)$request->query->get(AbstractCollection::PER_PAGE_PARAM_NAME)
                ?? AbstractCollection::DEFAULT_ITEMS_NUMBER_PER_PAGE)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/posts",
     *      tags={"Post"},
     *     summary="Create a new post",
     *     operationId="createPost",
     *     description="Create a new post.",
     * @OA\RequestBody(
     *         description="Create post",
     *          required=true,
     * @OA\JsonContent(ref="#/components/schemas/CreatePost")
     *     ),
     * @OA\Response(response=201,                               description="Post created"),
     * @OA\Response(response=400,                               description="Request validation error"),
     * @OA\Response(response=401,                               description="Authorization token must be provided"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @param CreatePostRequest $request
     * @return JsonResponse
     */
    public function store(CreatePostRequest $request)
    {
        return response()->json([
            'data' => Post::create($request->validated())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return PostResource
     * @OA\Get(
     *      path="/posts/{id}",
     *      operationId="getPostById",
     *      tags={"Post"},
     *      summary="Get a specific post",
     *      description="Returns post details",
     * @OA\Parameter(
     *          name="id",
     *          description="Post's ID",
     *          required=true,
     *          in="path",
     * @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successfully received specific post",
     * @OA\JsonContent(ref="#/components/schemas/Post")
     *       ),
     * @OA\Response(response=400,                         description="Bad request"),
     * @OA\Response(response=401,                         description="Authorization token must be provided"),
     * @OA\Response(response=404,                         description="Post Not Found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *     path="/posts/{id}",
     *     tags={"Post"},
     *     summary="Update a specific post",
     *     operationId="updatePost",
     *     description="Update post.",
     * @OA\Parameter(
     *          name="id",
     *          description="Post id",
     *          required=true,
     *          in="path",
     * @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *         description="Update post",
     *          required=true,
     * @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     * @OA\Response(response=200,                         description="Post updated"),
     * @OA\Response(response=401,                         description="Authorization token must be provided"),
     * @OA\Response(response=400,                         description="Request validation error"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return response()->json(['data' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(path="/posts/{id}",
     *   tags={"Post"},
     *   summary="Delete post",
     *   description="This can only be done by the logged in user.",
     *   operationId="deletePost",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of post to be deleted",
     *     required=true,
     * @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     * @OA\Response(response=200,       description="Post deleted"),
     * @OA\Response(response=400,       description="Invalid ID supplied"),
     * @OA\Response(response=401,       description="Authorization token must be provided"),
     * @OA\Response(response=404,       description="Post not found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @param Post $post
     * @return                          JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => sprintf('Post with ID %s was deleted', $post->id)
        ]);
    }
}
