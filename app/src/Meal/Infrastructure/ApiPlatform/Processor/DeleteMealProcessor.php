<?php

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\ICommandBus;
use App\Meal\Application\Command\DeleteMealICommand;
use App\Meal\Infrastructure\ApiPlatform\Resource\MealResource;

/**
 * @implements ProcessorInterface<MealResource, void>
 */
final readonly class DeleteMealProcessor implements ProcessorInterface
{

    public function __construct(
        private ICommandBus $commandBus
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $command = new DeleteMealICommand($data->id);

        $this->commandBus->dispatch($command);
    }
}