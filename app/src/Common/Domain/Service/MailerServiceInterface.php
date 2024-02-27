<?php

namespace App\Common\Domain\Service;

interface MailerServiceInterface
{
    public function send(Email $email): void;
}