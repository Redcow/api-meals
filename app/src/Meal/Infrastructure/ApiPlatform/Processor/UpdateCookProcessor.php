<?php

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Meal\Application\Command\UpdateCookCommand;
use App\Meal\Infrastructure\ApiPlatform\Resource\CookUserResource;

/**
 * @implements ProcessorInterface<UserInput, CookUserResource>
 */
final readonly class UpdateCookProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ){}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CookUserResource
    {
        $command = new UpdateCookCommand(
            +$uriVariables['id'],
            $data->username
        );

        $cook = $this->commandBus->dispatch($command);

        return CookUserResource::fromDomain($cook);
    }
}