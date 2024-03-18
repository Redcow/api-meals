<?php

namespace App\Meal\Infrastructure\Twig\Mail;

use App\Common\Domain\Service\Email;
use App\Meal\Application\Service\IMealMailMaker;
use App\Meal\Domain\Entity\CookUser;
use Twig\Environment;

class MealMailMaker implements IMealMailMaker
{
    public function __construct(
        private Environment $twig
    ){}

    public function createAccountConfirmationMail(CookUser $user): Email
    {
        $subject = 'Activate your account!'; // TODO translate

        // todo generate route url

        $content = $this->twig->render('@meal/AccountConfirmationMail.html.twig', [
            "user" => $user
        ]);

        return new Email(
            from: "noreply@meals.com",
            to: [$user->email],
            subject: $subject,
            content: $content
        );
    }
}