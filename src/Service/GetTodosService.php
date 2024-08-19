<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GetTodos;

class GetTodosService
{
    public function __construct(private GetTodos $todos)
    {
    }

    public function getTodos(): array
    {
        return $this->todos->get();
    }
}
