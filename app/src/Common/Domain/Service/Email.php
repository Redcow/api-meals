<?php

declare(strict_types=1);

namespace App\Common\Domain\Service;

readonly class Email
{
    public function __construct(
        public string $from,
        public array $to,
        public string $subject,
        public string $content
    ){}

    public function with(...$arguments): self
    {
        return new self(
            from: $arguments['from'] ?? $this->from,
            to: $arguments['to'] ?? $this->to,
            subject: $arguments['subject'] ?? $this->subject,
            content: $arguments['content'] ?? $this->content
        );
    }
}