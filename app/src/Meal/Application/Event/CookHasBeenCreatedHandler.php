<?php

namespace App\Meal\Application\Event;

use App\Common\Domain\Service\IMailerService;
use App\Meal\Application\Service\IMealMailMaker;

final readonly class CookHasBeenCreatedHandler
{
    public function __construct(
        private IMealMailMaker $mailMaker,
        private IMailerService $mailer
    ){}

    public function __invoke(CookHasBeenCreated $event): void
    {
        $email = $this->mailMaker->createAccountConfirmationMail($event->cook);

        $this->mailer->send($email);
    }
}