<?php

namespace App\Infrastructure\HttpClientApi;

use App\Application\Collection\TodoCollection;
use App\Application\Dto\ChangeTodoDto;
use App\Application\Dto\TodoDto;
use App\Application\Exception\TodoNotFoundException;
use App\Application\Exception\UserNotFoundException;
use App\Application\Service\TodosServiceInterface;
use App\Shared\Infrastructure\Serializer\JsonSerializer;
use App\UI\Http\Api\Request\RequestDto;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class TodoServiceApi implements TodosServiceInterface
{
    private const URI_ALL_TODO = '/todos';
    private const URI_USER_TODO = '/todos?userId=%d';
    private const URI_CHANGE_TODO = '/todos/%d';

    public function __construct(
        private HttpClientInterface $client,
        private string $domain
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTodos(): TodoCollection
    {
        $data = [];

        $response = $this->client->request(
            'GET',
            $this->domain.self::URI_ALL_TODO
        );

        foreach ($response->toArray() as $value) {
            $data[] = new TodoDto(
                userId: $value['userId'],
                todoId: $value['id'],
                title: $value['title'],
                completed: $value['completed']
            );
        }

        return new TodoCollection($data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws UserNotFoundException
     */
    public function getUserTodos(int $userId): TodoCollection
    {
        $data = [];

        if ($userId > 10 || $userId <= 0) {
            throw new UserNotFoundException();
        }

        $response = $this->client->request(
            'GET',
            $this->domain.sprintf(self::URI_USER_TODO, $userId)
        );

        foreach ($response->toArray() as $value) {
            $data[] = new TodoDto(
                userId: $value['userId'],
                todoId: $value['id'],
                title: $value['title'],
                completed: $value['completed']
            );
        }

        return new TodoCollection($data);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TodoNotFoundException
     */
    public function changeTodo(int $todoId, RequestDto $requestDto): ChangeTodoDto
    {
        $serializer = new JsonSerializer([
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ]);

        if ($todoId > 200 || $todoId <= 0) {
            throw new TodoNotFoundException();
        }

        $payload = $serializer->serializer($requestDto);

        $response = $this->client->request(
            'PUT',
            $this->domain.sprintf(self::URI_CHANGE_TODO, $todoId),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                ],
                'body' => $payload,
            ]
        );

        $data = $response->toArray();

        return new ChangeTodoDto(
            userId: $data['userId'],
            todoId: $data['id'],
            title: $data['title'],
            completed: $data['completed']
        );
    }
}
