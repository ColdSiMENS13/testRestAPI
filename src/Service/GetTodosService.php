<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\GetTodos;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GetTodosService
{
    private const CACHE_KEY = 'AllTodos_%s';
    public function __construct(private GetTodos $todos, private CacheInterface $cache)
    {
    }

    public function getTodos(): array
    {
        return $this->cache->get(
            sprintf(self::CACHE_KEY, md5(self::class)),
            function (ItemInterface $item): array {
                $item->expiresAfter(3600);
                return $this->todos->get();
            }
        );
    }
}
