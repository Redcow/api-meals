<?php

namespace App\Meal\Infrastructure\Twig\Mail;

use App\Common\Domain\Service\Email;
use App\Meal\Domain\Entity\CookUser;
use App\Meal\Domain\Service\MealMailMakerInterface;
use Twig\Environment;

class MealMailMaker implements MealMailMakerInterface
{
    public function __construct(
        private Environment $twig
    ){}

    public function createAccountConfirmationMail(CookUser $user): Email
    {
        //$from = 'noreply@'.(getenv('APP_MAIL_DOMAIN') ?? 'fail');
        $subject = 'Activate your account!'; // TODO translate

        $content = $this->twig->render('@meal/AccountConfirmationMail.html.twig', [
            "user" => $user
        ]);

        return new Email(
            from: "noreply@moi.com",
            to: [$user->email],
            subject: $subject,
            content: $content
        );
    }
}