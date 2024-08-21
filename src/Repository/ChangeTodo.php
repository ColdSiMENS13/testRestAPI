<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exceptions\DecodeErrorException;
use App\Exceptions\RequestErrorException;
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
     * @throws RequestErrorException
     * @throws DecodeErrorException
     */
    public function change(int $id, array $payload): array
    {
        try {
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
        } catch (TransportExceptionInterface $e) {
            throw new RequestErrorException($e->getMessage(), 2111);
        }

        try {
            return $response->toArray();
        } catch (ServerExceptionInterface $e) {
            throw new DecodeErrorException($e->getMessage(), 3111);
        } catch (RedirectionExceptionInterface $e) {
            throw new DecodeErrorException($e->getMessage(), 3112);
        } catch (DecodingExceptionInterface $e) {
            throw new DecodeErrorException($e->getMessage(), 3113);
        } catch (ClientExceptionInterface $e) {
            throw new DecodeErrorException($e->getMessage(), 3114);
        } catch (TransportExceptionInterface $e) {
            throw new DecodeErrorException($e->getMessage(), 3115);
        }
    }
}
