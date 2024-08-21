<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\DecodeErrorException;
use App\Exceptions\RequestErrorException;
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
        $response = $this->client->request(
            'GET',
            self::DOMAIN.sprintf(self::URI, $userId)
        );

        if ([] === $response->toArray()) {
            throw new UserNotFoundException();
        }

        return $response->toArray();
    }
}
