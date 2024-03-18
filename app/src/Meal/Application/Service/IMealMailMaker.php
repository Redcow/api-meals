<?php

namespace App\Meal\Application\Service;

use App\Common\Domain\Service\Email;
use App\Meal\Domain\Entity\CookUser;

interface IMealMailMaker
{
    public function createAccountConfirmationMail(CookUser $user): Email;
}