<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Exceptions\TodoNotFoundException;
use App\Repository\ChangeTodo;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChangeTodoTest extends Unit
{
    protected ChangeTodo $changeTodo;
    protected HttpClientInterface|MockObject $client;

    protected function _before()
    {
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->changeTodo = new ChangeTodo($this->client);
    }

    public function testException()
    {
        $this->expectException(TodoNotFoundException::class);

        $this->changeTodo->change(201, ['completed' => true]);
    }
}
