<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GetTodos;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class GetTodosService
{
    public function __construct(private GetTodos $todos)
    {
    }

    public function getTodos(): array
    {
        $cache = RedisAdapter::createConnection('redis://localhost:49100');
        $cache->set('userId', 1);

        return $this->todos->get();
    }
}
