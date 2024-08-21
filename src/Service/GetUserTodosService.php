<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GetUserTodos;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class GetUserTodosService
{
    private const CACHE_KEY = 'UserTodos_%s';
    public const TAG = 'UserTodos';

    public function __construct(private GetUserTodos $userTodos, private TagAwareCacheInterface $cache)
    {
    }

    public function getUserTodos(int $userId): array
    {
        return $this->cache->get(
            sprintf(self::CACHE_KEY, md5(self::class.$userId)),
            function (ItemInterface $item) use ($userId) {
                $item->tag(self::TAG);
                $item->expiresAfter(3600);

                return $this->userTodos->get($userId);
            }
        );
    }
}
