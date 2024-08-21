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

class GetTodos
{
    private const DOMAIN = 'https://jsonplaceholder.typicode.com';
    private const URI = '/todos';

    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws RequestErrorException
     * @throws DecodeErrorException
     */
    public function get(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                self::DOMAIN.self::URI
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
