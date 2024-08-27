<?php

namespace App\Shared\Infrastructure\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class JsonSerializer
{
    public function __construct(private readonly array $normalizers)
    {
    }

    public function serializer(mixed $data): string
    {
        $serializer = new Serializer(
            $this->normalizers,
            [
                new JsonEncoder(
                    new JsonEncode([
                        JsonEncode::OPTIONS => \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR,
                    ])
                ),
            ]
        );

        return $serializer->serialize($data, 'json');
    }

    public function deserializer(mixed $data, string $type): array|object
    {
        $serializer = new Serializer(
            $this->normalizers,
            [
                new JsonEncoder(
                    new JsonEncode([
                        JsonEncode::OPTIONS => \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR,
                    ])
                ),
            ]
        );

        return $serializer->deserialize($data, $type, 'json');
    }
}
