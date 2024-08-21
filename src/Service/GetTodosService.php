<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\ServerErrorException;
use App\Repository\GetTodos;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class GetTodosService
{
    private const CACHE_KEY = 'AllTodos_%s';
    public const TAG = 'AllTodos';

    public function __construct(private GetTodos $todos, private TagAwareCacheInterface $cache)
    {
    }

    /**
     * @throws ServerErrorException
     */
    public function getTodos(): array
    {
        try {
            return $this->cache->get(
                sprintf(self::CACHE_KEY, md5(self::class)),
                function (ItemInterface $item): array {
                    $item->tag(self::TAG);
                    $item->expiresAfter(3600);

                    return $this->todos->get();
                }
            );
        } catch (InvalidArgumentException $e) {
            throw new ServerErrorException($e->getMessage(), 1111);
        }
    }
}
