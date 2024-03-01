<?php

namespace App\Common\Infrastructure\Symfony\Mailer;

use App\Common\Domain\Service\IMailerService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use App\Common\Domain\Service\Email as DomainMail;

class SymfonyIMailer implements IMailerService
{
    public function __construct(
        private readonly MailerInterface $mailer
    ){}

    public function send(DomainMail $email): void
    {
        try {
            $this->mailer->send(self::transform($email));
        } catch (TransportExceptionInterface $e) {
            // TODO throw domain/internal exception
            throw new \Exception('fail sending mail');
        }
    }

    private static function transform(DomainMail $mail): Email
    {
        dump('transform');
        return (new Email())
            ->from($mail->from)
            ->to(...$mail->to)
            ->subject($mail->subject)
            ->html($mail->content);
    }
}