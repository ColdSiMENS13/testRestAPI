<?php

namespace App\Application\Service;


use App\Application\Collection\TodoCollection;
use App\Application\Dto\ChangeTodoDto;
use App\UI\Http\Api\Request\RequestDto;

interface TodosServiceInterface
{
    public function getTodos(): TodoCollection;

    public function getUserTodos(int $userId): TodoCollection;

    public function changeTodo(int $todoId, RequestDto $requestDto): ChangeTodoDto;
}
