<?php

namespace App\Controller;

use App\Service\GetTodosService;
use App\Service\GetUserTodosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class TodosController extends AbstractController
{
    public function __construct(
        private GetTodosService $todosService,
        private GetUserTodosService $userTodosService
    ) {
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route(path: '/todos', methods: 'GET')]
    public function getAllTodos(Request $request): Response
    {
        if (null !== $request->get('userId')) {
            return $this->json($this->userTodosService->getUserTodos((int) $request->get('userId')));
        }

        return $this->json($this->todosService->getTodos());
    }

    #[Route(path: '/todos/{id}', requirements: ['id' => '\d+'], methods: 'PUT')]
    public function createTodo(int $id, Request $request): Response
    {
        return $this->json($request->getContent());
    }
}
