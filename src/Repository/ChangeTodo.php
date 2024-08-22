<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\TodoNotFoundException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChangeTodo
{
    private const DOMAIN = 'https://jsonplaceholder.typicode.com';
    private const URI = '/todos/%d';

    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TodoNotFoundException
     */
    public function change(int $id, array $payload): array
    {
        if ($id > 200 || $id <= 0) {
            throw new TodoNotFoundException();
        }

        $response = $this->client->request(
            'PUT',
            self::DOMAIN.sprintf(self::URI, $id),
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
