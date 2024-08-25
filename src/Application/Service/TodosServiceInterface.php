<?php

namespace App\Application\Service;

interface TodosServiceInterface
{
    public function getTodos(): array;
    public function getUserTodos(int $userId): array;
    public function changeTodo(int $todoId, array $payload): array;
}