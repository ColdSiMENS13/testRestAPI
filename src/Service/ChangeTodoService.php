<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ChangeTodo;

class ChangeTodoService
{
    public function __construct(private ChangeTodo $changeTodo)
    {
    }

    public function change(int $id, array $payload): array
    {
        return $this->changeTodo->change($id, $payload);
    }
}
