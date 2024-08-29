<?php

declare(strict_types=1);

namespace App\UI\Http\Api\Request;

use Symfony\Component\HttpFoundation\Request;

class RequestDto
{
    public function __construct(
        public ?int $userId,
        public ?int $id,
        public ?string $title,
        public ?bool $completed
    ) {
    }

    public static function createFromRequest(Request $request): self
    {
        $data = json_decode($request->getContent(), true);

        return new self(
            userId: $data['userId'] ?? null,
            id: $data['id'] ?? null,
            title: $data['title'] ?? null,
            completed: $data['completed'] ?? null
        );
    }
}
