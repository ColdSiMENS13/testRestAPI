<?php

declare(strict_types=1);

namespace App\UI\Http\Api\Response\Error;

use App\Shared\Infrastructure\Serializer\JsonSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class JsonErrorResponse extends JsonResponse
{
    public function __construct(\Throwable $exception)
    {
        $serializer = new JsonSerializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ]);

        parent::__construct($serializer->serializer($exception), json: true);
    }
}
