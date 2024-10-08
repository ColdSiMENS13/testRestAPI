<?php

declare(strict_types=1);

namespace App\Application\Exception;

class UserNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('User not found', 1001);
    }
}
