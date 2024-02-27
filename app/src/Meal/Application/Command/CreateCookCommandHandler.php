<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\Service\MailerServiceInterface;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\CookUserRepositoryInterface;
use App\Meal\Domain\Service\MealMailMakerInterface;

#[CommandHandler]
final readonly class CreateCookCommandHandler
{
    public function __construct(
        private CookUserRepositoryInterface $repository,
        private MailerServiceInterface $mailer,
        private MealMailMakerInterface $mailMaker
    ){}

    public function __invoke(CreateCookCommand $command): CookUser
    {
        dump('hello');

        $cook = new CookUser(
            $command->email,
            $command->password,
            $command->username,
            ['ROLE_COOK']
        );

        dump($cook);

        $persistedCook = $this->repository->persist($cook);

        $this->sendConfirmationEmailTo($persistedCook); // TODO, dévier ca vers event ou command ?

        return $persistedCook;
    }

    private function sendConfirmationEmailTo(CookUser $cook): void
    {
        $email = $this->mailMaker->createAccountConfirmationMail($cook);

        $this->mailer->send($email);
    }
}