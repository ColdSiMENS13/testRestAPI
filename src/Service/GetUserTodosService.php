<?php

namespace App\Service;

use App\Repository\GetUserTodos;

class GetUserTodosService
{
    public function __construct(private GetUserTodos $userTodos)
    {
    }

    public function getUserTodos(int $userId): array
    {
        return $this->userTodos->get($userId);
    }
}
