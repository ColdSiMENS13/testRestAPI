<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Exceptions\UserNotFoundException;
use App\Repository\GetUserTodos;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetUserTodosTest extends Unit
{
    protected GetUserTodos $userTodos;
    protected HttpClientInterface|MockObject $client;

    protected function _before()
    {
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->userTodos = new GetUserTodos($this->client);
    }

    public function testException()
    {
        $this->expectException(UserNotFoundException::class);

        $this->userTodos->get(11);
    }
}
