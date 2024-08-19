<?php

declare(strict_types=1);

namespace App\Controller;

use App\Cache\Proxy;
use App\Service\ChangeTodoService;
use App\Service\GetTodosService;
use App\Service\GetUserTodosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    public function __construct(
        private GetTodosService $todosService,
        private GetUserTodosService $userTodosService,
        private ChangeTodoService $changeTodoService,
    ) {
    }

    #[Route(path: '/todos', methods: 'GET')]
    public function getAllTodos(Request $request): Response
    {
        if (null !== $request->get('userId')) {
            return $this->json($this->userTodosService->getUserTodos((int) $request->get('userId')));
        }

        return $this->json($this->todosService->getTodos());
    }

    #[Route(path: '/todos/{id}', requirements: ['id' => '\d+'], methods: 'PUT')]
    public function ChangeTodo(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        return $this->json($this->changeTodoService->change($id, $data));
    }

    #[Route(path: '/test', methods: 'GET')]
    public function testCache(): Response
    {
        return $this->json('nothing');
    }
}
