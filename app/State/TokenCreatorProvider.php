<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\ApiToken;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @implements ProviderInterface<?User>
 */
final class TokenCreatorProvider implements ProviderInterface {

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null {
        /** @var User $user */
        $user = User::find($uriVariables['id'] ?? null);
        $token = $user->createToken($user->name);
        $resource = new ApiToken();
        $resource->token = "Bearer " . $token->plainTextToken;
        return $resource;
    }
}
