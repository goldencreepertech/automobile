<?php

namespace Automobile\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Automobile API",
 *         version="1.0.0",
 *         description="API for managing Indian vehicles, variants, and parts in India only."
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="Primary API server"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="sanctum",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="token",
 *             description="Enter just the token value - Swagger will prepend 'Bearer ' automatically"
 *         )
 *     )
 * )
 */
class SwaggerDefinitions
{
}
