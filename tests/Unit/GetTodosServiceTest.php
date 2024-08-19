<?php

namespace App\Tests\Unit;

use App\Repository\GetTodos;
use App\Repository\GetTodosInterface;
use App\Service\GetTodosService;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;

class GetTodosServiceTest extends Unit
{
    protected GetTodosService $todosService;
    protected GetTodos|MockObject $todos;


    protected function _before()
    {
        $this->todos = $this->createMock(GetTodos::class);
        $this->todosService = new GetTodosService($this->todos);
    }

    public function testGetTodos()
    {
        $this->todos->expects($this->once())
            ->method('get')
            ->willReturn([0 => ['userId' => 1]]);

        $this->assertIsArray($this->todosService->getTodos());
    }
}
