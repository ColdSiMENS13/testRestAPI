<?php

namespace App\Infrastructure\Cache;

use App\Application\Service\TodosServiceInterface;
use App\Infrastructure\HttpClientApi\TodoServiceApi;

class CachedTodoServiceApi extends TodoServiceApi implements TodosServiceInterface
{
    public function getTodos(): array
    {

    }

    public function getUserTodos(int $userId): array
    {

    }

    public function changeTodo(int $todoId, array $payload): array
    {

    }
}