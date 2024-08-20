<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ChangeTodo;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ChangeTodoService
{
    public function __construct(private ChangeTodo $changeTodo, private TagAwareCacheInterface $cache)
    {
    }

    public function change(int $id, array $payload): array
    {
        $this->cache->invalidateTags(['AllTodos', 'UserTodos']);

        return $this->changeTodo->change($id, $payload);
    }
}
