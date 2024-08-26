<?php

declare(strict_types=1);

namespace App\UI\Http\Api\Controller;

use App\Application\Service\TodosServiceInterface;
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
    public function getTodos(Request $request): Response
    {
        if (null !== $request->get('userId')) {
            return $this->json($this->todosServiceApi->getUserTodos((int) $request->get('userId')));
        }

        return $this->json($this->todosServiceApi->getTodos());
    }

    #[Route(path: '/todos/{id}', requirements: ['id' => '\d+'], methods: 'PUT')]
    public function changeTodo(int $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        return $this->json($this->todosServiceApi->changeTodo($id, $data));
    }
}
