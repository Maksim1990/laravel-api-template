<?php

namespace App\OpenApi;

/**
 * @OA\Schema(schema="Post")
 */
class Post
{
    /**
     * @OA\Property(type="string")
     */
    public $title;

    /**
     * @OA\Property(type="string")
     */
    public $description;

    /**
     * @OA\Property(type="string")
     */
    public $slug;

    /**
     * @OA\Property(type="integer")
     */
    public $user_id;

}
/**
 * @OA\Schema(
 *   schema="CreatePost",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/Post"),
 *       @OA\Schema(
 *           required={"title","user_id","slug"}
 *       )
 *   }
 * )
 */
