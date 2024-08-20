<?php

declare(strict_types=1);

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChangeTodo
{
    private const URL = 'https://jsonplaceholder.typicode.com/todos/%d';
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function change(int $id, array $payload): array
    {
        $response = $this->client->request(
            'PUT',
            sprintf(self::URL, $id),
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
