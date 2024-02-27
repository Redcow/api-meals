<?php

namespace App\Meal\Domain\Service;

use App\Common\Domain\Service\Email;
use App\Meal\Domain\Entity\CookUser;

interface MealMailMakerInterface
{
    public function createAccountConfirmationMail(CookUser $user): Email;
}