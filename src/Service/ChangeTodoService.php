<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\ServerErrorException;
use App\Repository\ChangeTodo;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ChangeTodoService
{
    public function __construct(private ChangeTodo $changeTodo, private TagAwareCacheInterface $cache)
    {
    }

    /**
     * @throws ServerErrorException
     */
    public function change(int $id, array $payload): array
    {
        try {
            $this->cache->invalidateTags([GetTodosService::TAG, GetUserTodosService::TAG]);
        } catch (InvalidArgumentException $e) {
            throw new ServerErrorException($e->getMessage(), 1111);
        }

        return $this->changeTodo->change($id, $payload);
    }
}
