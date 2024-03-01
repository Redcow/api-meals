<?php

namespace App\Meal\Domain\Event;

use App\Common\Domain\Service\IMailerService;
use App\Meal\Domain\Service\MealMailMakerInterface;

final readonly class CookHasBeenCreatedHandler
{
    public function __construct(
        private MealMailMakerInterface $mailMaker,
        private IMailerService $mailer
    ){}

    public function __invoke(CookHasBeenCreated $event): void
    {
        $email = $this->mailMaker->createAccountConfirmationMail($event->cook);

        $this->mailer->send($email);
    }
}