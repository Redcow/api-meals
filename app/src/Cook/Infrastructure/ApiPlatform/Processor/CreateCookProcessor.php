<?php

namespace App\Cook\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Cook\Application\Command\CreateCookCommand;
use App\Cook\Domain\Entity\Cook;
use App\Cook\Infrastructure\ApiPlatform\Resource\CookResource;

/**
 * @implements ProcessorInterface<UserInput, CookResource>
 */
final readonly class CreateCookProcessor implements ProcessorInterface
{
    public function __construct(
        /** @var CommandBusInterface<Cook> $commandBus */
      private CommandBusInterface $commandBus
    ){}

    /**
     * @param UserInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return CookResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CookResource
    {
        $command = new CreateCookCommand(
            $data->email,
            $data->password,
            $data->username
        );

        $cook = $this->commandBus->dispatch($command);

        return CookResource::fromDomain($cook);
    }
}