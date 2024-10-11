<?php

declare(strict_types=1);

namespace App\Services\Notification;

use App\Services\Notification\Mail\Mail;

class NotificationFactory
{
    public function createNotification(NotificationType $type): NotificationInterface
    {
        return match ($type) {
            NotificationType::MAIL => new Mail(),
            default => throw new \UnexpectedValueException("Invalid notification type"),
        };
    }
}
