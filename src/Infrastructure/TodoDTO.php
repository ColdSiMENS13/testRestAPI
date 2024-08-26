<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Symfony\Component\Validator\Constraints as Assert;

class TodoDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public mixed $userId,
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public mixed $todoId,
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public mixed $title,
        #[Assert\NotBlank]
        #[Assert\Type('bool')]
        public mixed $completed
    ) {

    }
}
