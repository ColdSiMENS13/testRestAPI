<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Repository\ChangeTodo;
use App\Service\ChangeTodoService;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class ChangeTodoServiceTest extends Unit
{
    protected ChangeTodoService $changeTodoService;
    protected ChangeTodo|MockObject $changeTodo;
    protected TagAwareCacheInterface|MockObject $cache;

    protected function _before()
    {
        $this->cache = $this->createMock(TagAwareCacheInterface::class);
        $this->changeTodo = $this->createMock(ChangeTodo::class);
        $this->changeTodoService = new ChangeTodoService($this->changeTodo, $this->cache);
    }

    public function testChangeTodo()
    {
        $this->changeTodoService->change(1, ['completed' => true]);
    }

    public function testGetTodosException()
    {
    }
}
