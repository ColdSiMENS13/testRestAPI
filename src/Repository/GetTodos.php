<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetTodos
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function get(): array
    {
        $response = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/todos'
        );

        return $response->toArray();
    }
}
