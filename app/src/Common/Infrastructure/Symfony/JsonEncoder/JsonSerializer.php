<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Symfony\JsonEncoder;

use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonSerializer
{
    private SerializerInterface $serializer;

    static private ?JsonSerializer $instance = null;

    /**
     * @template T
     * @param string $json
     * @param class-string<T> $className
     * @return T
     */
    public function deserialize(string $json, string $className): mixed
    {
        return $this->serializer->deserialize(
            $json,
            $className,
            'json'
        );
    }

    public static function get(): self
    {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonDecode()]
        );
    }
}