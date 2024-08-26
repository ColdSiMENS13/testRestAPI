<?php

namespace App\Infrastructure\Cache;

use App\Infrastructure\HttpClientApi\TodoServiceApi;
use App\Infrastructure\HttpClientApi\TodosServiceApiInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class CachedTodoServiceApi extends TodoServiceApi implements TodosServiceApiInterface
{
    private const TODO_CACHE_KEY = 'AllTodos_%s';
    private const USER_TODO_CACHE_KEY = 'UserTodos_%s';
    private const TODO_TAG = 'AllTodos';
    private const USER_TODO_TAG = 'UserTodos';

    public function __construct(
        private TagAwareCacheInterface $cache,
        HttpClientInterface $client,
    ) {
        parent::__construct($client);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTodos(): array
    {
        $todos = $this->cache->get(
            sprintf(self::TODO_CACHE_KEY, md5(self::class)),
            function (ItemInterface $item): array {
                $todos = parent::getTodos();
                $item->tag(self::TODO_TAG);
                $item->expiresAfter(3600);

                return $todos;
            },
        );

        return $todos;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getUserTodos(int $userId): array
    {
        $userTodos = $this->cache->get(
            sprintf(self::USER_TODO_CACHE_KEY, md5(self::class.$userId)),
            function (ItemInterface $item) use ($userId) {
                $userTodos = parent::getUserTodos($userId);
                $item->tag(self::USER_TODO_TAG);
                $item->expiresAfter(3600);

                return $userTodos;
            }
        );

        return $userTodos;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function changeTodo(int $todoId, array $payload): array
    {
        $this->cache->invalidateTags([self::TODO_TAG, self::USER_TODO_TAG]);

        return parent::changeTodo($todoId, $payload);
    }
}
