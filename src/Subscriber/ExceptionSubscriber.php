<?php

declare(strict_types=1);

namespace App\Subscriber;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
            'console.error' => 'onConsoleError',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $response = new JsonResponse(['error' => $exception->getMessage()], $exception->getStatusCode());
        } elseif ($exception instanceof \UnexpectedValueException) {
            $response = new JsonResponse(
                ['error' => $exception->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } else {
            $response = new JsonResponse(
                ['error' => 'Unexpected error occurred'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        $event->setResponse($response);
    }

    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $error = $event->getError();
        $event->getOutput()->writeln($error->getMessage());

        if ($error instanceof InvalidArgumentException) {
            $event->setExitCode(Command::INVALID);
        } else {
            $event->setExitCode(Command::FAILURE);
        }
    }
}
