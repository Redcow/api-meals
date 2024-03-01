<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\ICommandBus;
use App\Common\Infrastructure\ApiPlatform\Input\UserInput;
use App\Order\Application\Command\CreateClientUserICommand;
use App\Order\Domain\Entity\ClientUser;
use App\Order\Infrastructure\ApiPlatform\Resource\ClientUserResource;

/**
 * @implements ProcessorInterface<UserInput, ClientUserResource>
 */
final readonly class CreateClientUserProcessor implements ProcessorInterface
{
    public function __construct(
        private ICommandBus $commandBus
    ){}

    /**
     * @param UserInput $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return ClientUserResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ClientUserResource
    {
        $command = new CreateClientUserICommand(
            $data->email,
            $data->password,
            $data->username
        );

        $clientUser = $this->commandBus->dispatch($command);

        return ClientUserResource::fromDomain($clientUser);
    }
}