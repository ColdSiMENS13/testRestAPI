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
        if ($this->checkException($exception)) {
            $message = sprintf('%s with code %s', $exception->getMessage(), $exception->getCode());
        } else {
            $message = $this->buildMessage($exception);
        }

        $event->setResponse(new JsonResponse($message));
        $event->allowCustomResponseCode();
    }

    private function buildMessage(\Throwable $throwable): string
    {
        return sprintf(
            'Uncaught PHP Exception %s: "%s" at %s line %s',
            get_class($throwable),
            $throwable->getMessage(),
            $throwable->getFile(),
            $throwable->getLine()
        );
    }

    private function checkException(\Throwable $throwable): bool
    {
        return match (true) {
            $throwable instanceof UserNotFoundException => true,
            default => false
        };
    }
}
