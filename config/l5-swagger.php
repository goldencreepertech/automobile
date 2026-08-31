<?php

use L5Swagger\Generator;
use OpenApi\Analysers\DocBlockAnnotationFactory;
use OpenApi\Analysers\ReflectionAnalyser;

return [
    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Automobile API',
            ],

            'routes' => [
                'api' => 'api/documentation',
                'docs' => 'docs',
                'oauth2_callback' => 'api/oauth2-callback',
                'middleware' => [
                    'api' => [],
                    'asset' => [],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
                'group_options' => [],
            ],

            'paths' => [
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', true),
                'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist/'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),
                'annotations' => [
                    base_path('app'),
                    base_path('src'),
                    base_path('routes'),
                ],
            ],
            'proxy' => null,
            'operations_sort' => null,
            'additional_config_url' => null,
            'validator_url' => null,
            'generate_always' => false,

            'constants' => [
                'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://localhost'),
            ],
        ],
    ],

    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],

        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => env('L5_SWAGGER_BASE_PATH', null),
            'excludes' => [],
        ],

        'proxy' => null,

        'operations_sort' => null,

        'additional_config_url' => null,

        'validator_url' => null,
        'generate_always' => false,

        'scanOptions' => [
            'generator_factory' => null,
            'default_processors_configuration' => [],
            // The bundled controllers use @OA docblock annotations (not PHP 8 attributes),
            // so scan with the doc-block factory. Needs doctrine/annotations (dev); falls
            // back to swagger-php's default analyser when it (or swagger-php) is absent.
            'analyser' => class_exists(DocBlockAnnotationFactory::class)
                ? new ReflectionAnalyser([new DocBlockAnnotationFactory])
                : null,
            'analysis' => null,
            'processors' => [],
            'pattern' => null,
            'exclude' => [],
            'open_api_spec_version' => env('L5_SWAGGER_OPEN_API_SPEC_VERSION', Generator::OPEN_API_DEFAULT_SPEC_VERSION),
        ],

        'securityDefinitions' => [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'token',
                    'description' => "Enter just the token value - Swagger will prepend 'Bearer ' automatically",
                ],
            ],
            'security' => [
                [
                    'bearerAuth' => [],
                ],
            ],
        ],
    ],
];
