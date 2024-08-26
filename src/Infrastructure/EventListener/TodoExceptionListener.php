<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Application\Exception\TodoNotFoundException;
use App\Application\Exception\UserNotFoundException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener('kernel.exception')]
final readonly class TodoExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($this->checkException($exception)) {
            $message = sprintf('%s, code: %s', $exception->getMessage(), $exception->getCode());
        } else {
            $message = $this->buildMessage($exception);
        }

        $event->setResponse(new JsonResponse($message));
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
            $throwable instanceof UserNotFoundException,
                $throwable instanceof TodoNotFoundException => true,
            default => false
        };
    }
}
