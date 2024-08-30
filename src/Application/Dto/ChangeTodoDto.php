<?php

declare(strict_types=1);

namespace App\Application\Dto;

readonly class ChangeTodoDto
{
    public function __construct(
        public ?int $userId,
        public int $todoId,
        public ?string $title,
        public ?bool $completed
    ) {
    }
}
