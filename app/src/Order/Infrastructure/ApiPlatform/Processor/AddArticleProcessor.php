<?php

namespace App\Order\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\ICommandBus;
use App\Order\Application\Command\AddArticleICommand;
use App\Order\Infrastructure\ApiPlatform\Input\ArticleInput;

/**
 * @implements ProcessorInterface<ArticleInput, void>
 */
class AddArticleProcessor implements ProcessorInterface
{
    public function __construct(
        private ICommandBus $commandBus
    ) {}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $command = new AddArticleICommand();

        $this->commandBus->dispatch($command);
    }
}