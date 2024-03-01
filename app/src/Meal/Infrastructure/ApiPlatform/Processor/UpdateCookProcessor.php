<?php

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\ICommandBus;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Meal\Application\Command\UpdateCookICommand;
use App\Meal\Infrastructure\ApiPlatform\Resource\CookUserResource;

/**
 * @implements ProcessorInterface<UserInput, CookUserResource>
 */
final readonly class UpdateCookProcessor implements ProcessorInterface
{
    public function __construct(
        private ICommandBus $commandBus
    ){}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CookUserResource
    {
        $command = new UpdateCookICommand(
            +$uriVariables['id'],
            $data->username
        );

        $cook = $this->commandBus->dispatch($command);

        return CookUserResource::fromDomain($cook);
    }
}