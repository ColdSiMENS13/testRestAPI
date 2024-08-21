<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Repository\GetTodos;
use App\Service\GetTodosService;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class GetTodosServiceTest extends Unit
{
    protected GetTodosService $todosService;
    protected GetTodos|MockObject $todos;
    protected TagAwareCacheInterface|MockObject $cache;

    protected function _before()
    {
        $this->cache = $this->createMock(TagAwareCacheInterface::class);
        $this->todos = $this->createMock(GetTodos::class);
        $this->todosService = new GetTodosService($this->todos, $this->cache);
    }

    public function testGetTodosFromCache()
    {
        $this->cache->expects($this->once())
            ->method('get')
            ->willReturn([0 => ['userId' => 1]]);

        $this->todos->expects($this->never())
            ->method('get');

        $this->todosService->getTodos();
    }

    public function testGetTodos()
    {
        $this->todos->expects($this->once())
            ->method('get')
            ->willReturn([0 => ['userId' => 1]]);

        $this->todosService->getTodos();
    }

    public function testGetTodosException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->cache->expects($this->once())
            ->method('get')
            ->willThrowException(new \InvalidArgumentException());

        $this->todosService->getTodos();
    }
}
