<?php

namespace App\Application\Service;

class TodoService implements TodosServiceInterface
{
    public function getTodos(): array
    {
        return [];
    }

    public function getUserTodos(int $userId): array
    {
        return [];
    }

    public function changeTodo(int $todoId, array $payload): array
    {
        return [];
    }
}