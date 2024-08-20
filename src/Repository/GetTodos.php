<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetTodos
{
    private const URL = 'https://jsonplaceholder.typicode.com/todos';

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function get(): array
    {
        $response = $this->client->request(
            'GET',
            self::URL
        );

        return $response->toArray();
    }
}
