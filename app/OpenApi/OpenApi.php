<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Employee API",
 *     version="1.0.0",
 *     description="API documentation for Employee CRUD operations"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Local API server"
 * )
 */
class OpenApi
{
    // This file is just for Swagger metadata
}
