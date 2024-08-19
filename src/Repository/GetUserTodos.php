<?php

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetUserTodos
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function get(int $userId): array
    {
        $response = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/todos?userId='.$userId
        );

        return $response->toArray();
    }
}