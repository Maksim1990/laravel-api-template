<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\AbstractCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsers",
     *      tags={"User"},
     *      summary="Get all users",
     *      description="Returns all users details",
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
     *          example="posts",
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
     *          description="Successfully received available users",
     * @OA\JsonContent(ref="#/components/schemas/User"),
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
        return new UserCollection(
            User::paginate((int)$request->query->get(AbstractCollection::PER_PAGE_PARAM_NAME)
                ?? AbstractCollection::DEFAULT_ITEMS_NUMBER_PER_PAGE)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/users",
     *      tags={"User"},
     *     summary="Create a new user",
     *     operationId="createUser",
     *     description="Create a new user.",
     * @OA\RequestBody(
     *         description="Create user",
     *          required=true,
     * @OA\JsonContent(ref="#/components/schemas/CreateUser")
     *     ),
     * @OA\Response(response=201,                               description="User created"),
     * @OA\Response(response=400,                               description="Request validation error"),
     * @OA\Response(response=401,                               description="Authorization token must be provided"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        return response()->json([
            'data' => User::create($request->validated())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUserById",
     *      tags={"User"},
     *      summary="Get a specific user",
     *      description="Returns user details",
     * @OA\Parameter(
     *          name="id",
     *          description="User's ID",
     *          required=true,
     *          in="path",
     * @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * @OA\Response(
     *          response=200,
     *          description="Successfully received specific user",
     * @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     * @OA\Response(response=400,                         description="Bad request"),
     * @OA\Response(response=401,                         description="Authorization token must be provided"),
     * @OA\Response(response=404,                         description="User Not Found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *     path="/users/{id}",
     *     tags={"User"},
     *     summary="Update a specific user",
     *     operationId="updateUser",
     *     description="Update user.",
     * @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     * @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *         description="Update user",
     *          required=true,
     * @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * @OA\Response(response=200,                         description="User updated"),
     * @OA\Response(response=401,                         description="Authorization token must be provided"),
     * @OA\Response(response=400,                         description="Request validation error"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json(['data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(path="/users/{id}",
     *   tags={"User"},
     *   summary="Delete user",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteUser",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID of user to be deleted",
     *     required=true,
     * @OA\Schema(
     *         type="integer"
     *     )
     *   ),
     * @OA\Response(response=200,       description="User deleted"),
     * @OA\Response(response=400,       description="Invalid ID supplied"),
     * @OA\Response(response=401,       description="Authorization token must be provided"),
     * @OA\Response(response=404,       description="User not found"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * @param User $user
     * @return                          JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => sprintf('User with ID %s was deleted', $user->id)
        ]);
    }
}
