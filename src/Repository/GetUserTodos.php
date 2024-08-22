<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\UserNotFoundException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetUserTodos
{
    private const DOMAIN = 'https://jsonplaceholder.typicode.com';
    private const URI = '/todos?userId=%d';

    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws UserNotFoundException
     */
    public function get(int $userId): array
    {
        if ($userId > 10 || $userId <= 0) {
            throw new UserNotFoundException();
        }

        $response = $this->client->request(
            'GET',
            self::DOMAIN.sprintf(self::URI, $userId)
        );

        return $response->toArray();
    }
}
