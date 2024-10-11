<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Events\DonutCalculationFinishEvent;
use App\Services\Notification\NotificationFactory;
use App\Services\Notification\NotificationType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DonutCalculationFinishSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly NotificationFactory $notificationFactory)
    {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            DonutCalculationFinishEvent::NAME => 'onDonutCalculationFinish',
        ];
    }

    public function onDonutCalculationFinish(DonutCalculationFinishEvent $event): void
    {
        $workers = $event->getWorkers();

        foreach ($workers as $worker) {
            if ($this->workerEarnedMoreThan10Donuts($worker->getEarnedDonuts())) {
                $this->sendMessageAbout10DonutsExceeded(NotificationType::MAIL, $worker->getEmail());
            }
        }
    }

    private function workerEarnedMoreThan10Donuts(int $earnedDonuts): bool
    {
        return $earnedDonuts > 10;
    }

    private function sendMessageAbout10DonutsExceeded(NotificationType $notificationType, string $recipient): void
    {
        $notification = $this->notificationFactory->createNotification($notificationType);

        $notification->send(
            $recipient,
            'You’re the best',
            'You earned more than 10 donuts this week!'
        );
    }
}
