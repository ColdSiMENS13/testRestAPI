<?php

namespace App\Infrastructure\Cache;

use App\Application\Collection\TodoCollection;
use App\Application\Dto\ChangeTodoDto;
use App\Application\Dto\TodoDto;
use App\Application\Service\TodosServiceInterface;
use App\Shared\Infrastructure\Serializer\JsonSerializer;
use App\UI\Http\Api\Request\RequestDto;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

readonly class CachedTodoServiceApi implements TodosServiceInterface
{
    private const TODO_CACHE_KEY = 'AllTodos_%s';
    private const USER_TODO_CACHE_KEY = 'UserTodos_%s';
    private const TODO_TAG = 'AllTodos';
    private const USER_TODO_TAG = 'UserTodos';

    public function __construct(
        private TagAwareCacheInterface $cache,
        private TodosServiceInterface $todosServiceApi
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTodos(): TodoCollection
    {
        $todos = $this->cache->get(
            sprintf(self::TODO_CACHE_KEY, md5(self::class)),
            function (ItemInterface $item) {
                $todos = $this->todosServiceApi->getTodos();
                $item->tag(self::TODO_TAG);
                $item->expiresAfter(3600);

                return $this->getSerializer()->serializer($todos);
            },
        );

        $todoDto = $this->getSerializer()->deserializer($todos, TodoDto::class.'[]');

        return new TodoCollection($todoDto);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getUserTodos(int $userId): TodoCollection
    {
        $userTodos = $this->cache->get(
            sprintf(self::USER_TODO_CACHE_KEY, md5(self::class.$userId)),
            function (ItemInterface $item) use ($userId) {
                $userTodos = $this->todosServiceApi->getUserTodos($userId);
                $item->tag(self::USER_TODO_TAG);
                $item->expiresAfter(3600);

                return $this->getSerializer()->serializer($userTodos);
            }
        );

        $userTodoDto = $this->getSerializer()->deserializer($userTodos, TodoDto::class.'[]');

        return new TodoCollection($userTodoDto);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws InvalidArgumentException
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function changeTodo(int $todoId, RequestDto $requestDto): ChangeTodoDto
    {
        $this->cache->invalidateTags([self::TODO_TAG, self::USER_TODO_TAG]);

        return $this->todosServiceApi->changeTodo($todoId, $requestDto);
    }

    public function getSerializer(): JsonSerializer
    {
        return new JsonSerializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ]);
    }
}
