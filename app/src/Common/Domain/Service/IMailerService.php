<?php

namespace App\Common\Domain\Service;

interface IMailerService
{
    public function send(Email $email): void;
}