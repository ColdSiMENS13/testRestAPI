<?php

declare(strict_types=1);

namespace App\Application\Exception;

class TodoNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Todo not found', 1002);
    }
}
