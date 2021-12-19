<?php

namespace App\OpenApi;

/**
 * @OA\Schema(schema="User")
 */
class User
{
    /**
     * @OA\Property(type="string")
     */
    public $name;

    /**
     * @OA\Property(type="string")
     */
    public $email;

}
/**
 *  @OA\Schema(
 *   schema="CreateUser",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/User"),
 *       @OA\Schema(
 *           required={"name","email"}
 *       )
 *   }
 * )
 */
