<?php

declare(strict_types=1);

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
//use App\Common\Application\Query\QueryBusInterface;
//use App\Cook\Application\Query\FindCookQuery;
use App\Meal\Application\Command\CreateMealCommand;
use App\Meal\Infrastructure\ApiPlatform\Input\MealInput;
use App\Meal\Infrastructure\ApiPlatform\Resource\MealResource;

/**
 * @implements ProcessorInterface<MealInput, MealResource>
 */
final readonly class CreateMealProcessor implements ProcessorInterface
{
    public function __construct(
        //private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus
    ) {}

    /**
     * @param MealInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return MealResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MealResource
    {
        /*$query = new FindCookQuery($data->makerId);
        $cook = $this->queryBus->ask($query);*/

        $command = new CreateMealCommand(
            $data->name,
            $data->price,
            $data->makerId
        );

        $meal = $this->commandBus->dispatch($command);

        return MealResource::fromDomain($meal);
    }
}