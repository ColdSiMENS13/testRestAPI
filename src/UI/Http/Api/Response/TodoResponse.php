<?php

declare(strict_types=1);

namespace App\UI\Http\Api\Response;

use App\Application\Collection\TodoCollection;
use App\Shared\Infrastructure\Serializer\JsonSerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TodoResponse extends JsonResponse
{
    public function __construct(TodoCollection $response)
    {
        $serializer = new JsonSerializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ]);

        parent::__construct($serializer->serializer($response), json: true);
    }
}
