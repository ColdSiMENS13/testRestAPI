<?php

namespace App\Infrastructure\HttpClientApi;

interface TodosServiceApiInterface
{
    public function getTodos(): array;
    public function getUserTodos(int $userId): array;
    public function changeTodo(int $todoId, array $payload): array;
}