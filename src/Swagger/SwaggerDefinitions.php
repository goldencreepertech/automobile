<?php

namespace Automobile\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Automobile API",
 *     version="1.0.0",
 *     description="REST API for the bundled vehicle database (manufacturers, models, variants, vehicles, parts)."
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Primary API server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="token",
 *     description="Bearer token issued by the host application's auth. Enter just the token value."
 * )
 */
class SwaggerDefinitions {}
