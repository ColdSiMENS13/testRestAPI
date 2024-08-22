<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Repository\GetUserTodos;
use App\Service\GetUserTodosService;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class GetUserTodosServiceTest extends Unit
{
    protected GetUserTodosService $userTodosService;
    protected GetUserTodos|MockObject $userTodos;
    protected TagAwareCacheInterface|MockObject $cache;

    protected function _before()
    {
        $this->cache = $this->createMock(TagAwareCacheInterface::class);
        $this->userTodos = $this->createMock(GetUserTodos::class);
        $this->userTodosService = new GetUserTodosService($this->userTodos, $this->cache);
    }

    public function testGetUserTodosFromCache()
    {
        $this->cache->expects($this->once())
            ->method('get')
            ->willReturn([0 => ['userId' => 1]]);

        $this->userTodos->expects($this->never())
            ->method('get');

        $this->assertEquals([0 => ['userId' => 1]], $this->userTodosService->getUserTodos(1));
    }

    public function testGetUserTodos()
    {
        $this->cache->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $this->userTodos->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn([0 => ['userId' => 1]]);

        $this->assertEquals([0 => ['userId' => 1]], $this->userTodosService->getUserTodos(1));
    }
}
