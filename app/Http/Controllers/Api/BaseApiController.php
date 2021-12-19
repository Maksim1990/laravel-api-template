<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel Template API",
 *      description="Laravel Template API documentation",
 * @OA\Contact(
 *          email="narushevich.maksim@gmail.com"
 *      ),
 * @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API documentation"
 * )
 * @OA\SecurityScheme(
 * @OA\Flow(
 *         flow="clientCredentials",
 *         tokenUrl="oauth/token",
 *         scopes={}
 *     ),
 *     securityScheme="bearerAuth",
 *     in="header",
 *     type="http",
 *     description="Oauth2 security",
 *     name="oauth2",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 */
class BaseApiController extends Controller
{

}
