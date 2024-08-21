<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ChangeTodo;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ChangeTodoService
{
    public function __construct(private ChangeTodo $changeTodo, private TagAwareCacheInterface $cache)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function change(int $id, array $payload): array
    {
        $this->cache->invalidateTags([GetTodosService::TAG, GetUserTodosService::TAG]);

        return $this->changeTodo->change($id, $payload);
    }
}
