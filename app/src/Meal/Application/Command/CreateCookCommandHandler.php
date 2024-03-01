<?php

declare(strict_types=1);

namespace App\Meal\Application\Command;

use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\Service\IMailerService;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Repository\ICookUserRepository;
use App\Meal\Domain\Service\MealMailMakerInterface;

#[CommandHandler]
final readonly class CreateCookCommandHandler
{
    public function __construct(
        private ICookUserRepository    $repository,
        private IMailerService         $mailer,
        private MealMailMakerInterface $mailMaker
    ){}

    public function __invoke(CreateCookICommand $command): CookUser
    {
        $cook = new CookUser(
            $command->email,
            $command->password,
            $command->username,
            ['ROLE_COOK']
        );

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