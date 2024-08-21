<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener('kernel.exception')]
final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            '%s with code %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $event->setResponse(new JsonResponse($message));
    }
}
