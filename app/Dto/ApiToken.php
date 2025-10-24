<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Http\Middleware\EnsureAuth;
use App\State\TokenCreatorProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user/token/{id}',
            openapi: new Operation(
                description: "Hier kann man einen API Token holen für die restlichen Routen."
            ),
            provider: TokenCreatorProvider::class,
            middleware: EnsureAuth::class
        )
    ],
    routePrefix: '',
)]
final class ApiToken {

    public ?string $token = null;
}
