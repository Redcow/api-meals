<?php

namespace App\Meal\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\ICommandBus;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Meal\Application\Command\CreateCookICommand;
use App\Meal\Infrastructure\ApiPlatform\Resource\CookUserResource;

/**
 * @implements ProcessorInterface<UserInput, CookUserResource>
 */
final readonly class CreateCookProcessor implements ProcessorInterface
{
    public function __construct(
      private ICommandBus $commandBus
    ){}

    /**
     * @param UserInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return CookUserResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CookUserResource
    {
        $command = new CreateCookICommand(
            $data->email,
            $data->password,
            $data->username
        );

        $cook = $this->commandBus->dispatch($command);

        return CookUserResource::fromDomain($cook);
    }
}