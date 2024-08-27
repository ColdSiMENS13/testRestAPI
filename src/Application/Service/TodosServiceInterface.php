<?php

namespace App\Application\Service;


use App\Application\Collection\TodoCollection;

interface TodosServiceInterface
{
    public function getTodos(): TodoCollection;

    public function getUserTodos(int $userId): array;

    public function changeTodo(int $todoId, array $payload): array;
}
