<?php

declare(strict_types=1);

namespace App\UI\Http\Api\Controller;

use App\Application\Service\TodosServiceInterface;
use App\UI\Http\Api\Request\RequestDto;
use App\UI\Http\Api\Response\TodoResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    public function __construct(
        private TodosServiceInterface $todosServiceApi,
    ) {
    }

    #[Route(path: '/todos', methods: 'GET')]
    public function getTodos(): Response
    {
        $result = $this->todosServiceApi->getTodos();

        return new TodoResponse($result);
    }

    #[Route(path: '/user/{id}/todos', methods: 'GET')]
    public function getUserTodos(int $id): Response
    {
        $result = $this->todosServiceApi->getUserTodos($id);

        return new TodoResponse($result);
    }

    #[Route(path: '/todos/{id}', requirements: ['id' => '\d+'], methods: 'PUT')]
    public function changeTodo(int $id, Request $request): Response
    {
        $result = $this->todosServiceApi->changeTodo($id, RequestDto::createFromRequest($request));

        return new TodoResponse($result);
    }
}
