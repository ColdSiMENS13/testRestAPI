<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GetUserTodos;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GetUserTodosService
{
    private const CACHE_KEY = 'UserTodos_%s';
    public function __construct(private GetUserTodos $userTodos, private CacheInterface $cache)
    {
    }

    public function getUserTodos(int $userId): array
    {
        return $this->cache->get(
            sprintf(self::CACHE_KEY, md5(self::class)),
            function (ItemInterface $item) use ($userId) {
                $item->expiresAfter(3600);
                return $this->userTodos->get($userId);
            }
        );
    }
}
