<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetUserTodos
{
    private const URL = 'https://jsonplaceholder.typicode.com/todos?userId=%d';

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function get(int $userId): array
    {
        $response = $this->client->request(
            'GET',
            sprintf(self::URL, $userId)
        );

        return $response->toArray();
    }
}
