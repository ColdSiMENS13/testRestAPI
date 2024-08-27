<?php

declare(strict_types=1);

namespace App\Application\Collection;

use App\Application\Dto\TodoDto;

class TodoCollection implements \IteratorAggregate
{
    /**
     * @var TodoDto[]
     */
    private array $data = [];

    public function __construct(array $data)
    {
        foreach ($data as $todoDto) {
            $this->add($todoDto);
        }
    }

    public function add(TodoDto $dto): void
    {
        $this->data[$dto->todoId] = $dto;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->data);
    }
}
