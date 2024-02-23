<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
use App\Common\Application\Query\QueryBusInterface;
use App\Common\Domain\Entity\Collection;
use App\Common\Infrastructure\Doctrine\Entity\User;
use App\Meal\Application\Query\FindMealCollectionQuery;
use App\Meal\Domain\Entity\Meal;
use App\Order\Application\Command\CreateOrderCommand;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Infrastructure\ApiPlatform\Input\ArticleInput;
use App\Order\Infrastructure\ApiPlatform\Input\BasketInput;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @implements ProcessorInterface<BasketInput, void>
 */
final readonly class CreateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private Security $security
    ){}

    /**
     * @param BasketInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     * @throws \Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $meals = $this->queryOrderedMeals($data);

        $answer = $this->everyMealIsAvailable($data, $meals);

        if ($answer === false) {
            throw new \Exception("articles are not available anymore");
            // TODO handle exception better
        }

        $this->createOrder($data);
    }

    /**
     * @param BasketInput $input
     * @return Collection<Meal>
     */
    private function queryOrderedMeals(BasketInput $input): Collection
    {
        $query = new FindMealCollectionQuery(
            $input->articles->map(
                fn (ArticleInput $article) => $article->mealId
            )
        );

        /** @var Collection<Meal> $meals*/
        return $this->queryBus->ask($query);
    }

    private function everyMealIsAvailable(BasketInput $input, Collection $meals): bool
    {
        return $input->articles->every(
            function (ArticleInput $article) use ($meals) {
                $meal = $meals->find( fn (Meal $meal) => $meal->id === $article->mealId);

                if ( $meal === null ) return false;

                return $article->quantity <= $meal->quantity;
            }
        );
    }

    private function createOrder(BasketInput $input): void
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $clientUser = new ClientUser(
            email: $user->getEmail(),
            password: "none",
            username: $user->getUsername(),
            roles: $user->getRoles(),
            id: $user->getId()
        );

        $command = new CreateOrderCommand(
            $input->articles,
            $clientUser
        );

        $this->commandBus->dispatch($command);
    }
}