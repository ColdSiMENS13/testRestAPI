<?php

namespace App\Infrastructure\HttpClientApi;

use App\Exceptions\TodoNotFoundException;
use App\Exceptions\UserNotFoundException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class TodoServiceApi implements TodosServiceApiInterface
{
    private const URI_ALL_TODO = '/todos';
    private const URI_USER_TODO = '/todos?userId=%d';
    private const URI_CHANGE_TODO = '/todos/%d';
    private string $domain;

    public function __construct(private HttpClientInterface $client)
    {
        $this->domain = $_ENV['DOMAIN_URL'];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTodos(): array
    {
        $response = $this->client->request(
            'GET',
            $this->domain.self::URI_ALL_TODO
        );

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws UserNotFoundException
     */
    public function getUserTodos(int $userId): array
    {
        if ($userId > 10 || $userId <= 0) {
            throw new UserNotFoundException();
        }

        $response = $this->client->request(
            'GET',
            $this->domain.sprintf(self::URI_USER_TODO, $userId)
        );

        return $response->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TodoNotFoundException
     */
    public function changeTodo(int $todoId, array $payload): array
    {
        if ($todoId > 200 || $todoId <= 0) {
            throw new TodoNotFoundException();
        }

        $response = $this->client->request(
            'PUT',
            $this->domain.sprintf(self::URI_CHANGE_TODO, $todoId),
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                ],
                'body' => json_encode($payload),
            ]
        );

        return $response->toArray();
    }
}
