<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\IQueryBus;
use App\Meal\Application\Query\FindMealIQuery;
use App\Meal\Infrastructure\ApiPlatform\Resource\MealResource;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProviderInterface<MealResource>
 */
readonly class MealItemProvider implements ProviderInterface
{
    public function __construct(
        private IQueryBus $queryBus,
        private Security  $security
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): MealResource
    {
        $user = $this->security->getUser();

        xdebug_break();

        $query = new FindMealIQuery($uriVariables['id']);

        $meal = $this->queryBus->ask($query);

        // TODO 1. arreter le nullable et gérer proprement le result
        // ici en bout de chaine, pas de result pattern

        // TODO 3. nettoyer les anciens fichiers des travaux de tatonnement avec la doc
        // Conserver le decorator redis
        // Trouvez la façon indus de lier Redis à Doctrine !!!

        return MealResource::fromDomain($meal);
    }
}