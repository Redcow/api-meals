<?php

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
use App\Meal\Application\Command\DeleteMealCommand;
use App\Meal\Infrastructure\ApiPlatform\Resource\MealResource;

/**
 * @implements ProcessorInterface<MealResource, void>
 */
final readonly class DeleteMealProcessor implements ProcessorInterface
{

    public function __construct(
        private CommandBusInterface $commandBus
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteMealCommand($data->id);

        $this->commandBus->dispatch($command);
    }
}