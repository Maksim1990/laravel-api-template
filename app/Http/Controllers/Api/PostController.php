<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\AbstractCollection;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\User;
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

    public function store(CreatePostRequest $request)
    {
        return response()->json([
            'data' => Post::create($request->validated())
        ]);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
