<?php

namespace App\Order\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBusInterface;
use App\Order\Application\Command\AddArticleCommand;
use App\Order\Infrastructure\ApiPlatform\Input\ArticleInput;

/**
 * @implements ProcessorInterface<ArticleInput, void>
 */
class AddArticleProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new AddArticleCommand();

        $this->commandBus->dispatch($command);
    }
}